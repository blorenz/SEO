using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using HtmlAgilityPack;
using WatiN.Core;
using System.Configuration;
using Microsoft.Win32;
using System.Net;
using WebProperties;

namespace WebTwoOh
{
    public partial class Form1 : System.Windows.Forms.Form
    {
  
        private WatiN.Core.DialogHandlers.WebBrowserIE[] ie = new WatiN.Core.DialogHandlers.WebBrowserIE[2];
        Web20 wb20 = null;
        Random rand = null;
        List<WebBrowser> webBrowsers = new List<WebBrowser>();

        List<System.Threading.Thread> threadList = new List<System.Threading.Thread>();
        Dictionary<String, WebProperties.baseWebProperty> dict = null;

        private void ShowInTextBox(string theMessage)
        {
            richTextBox1.Text = theMessage;
            Application.DoEvents();
        }

        public WebBrowser newWebBrowser()
        {
            WebBrowser wb = new WebBrowser();

            wb.ScriptErrorsSuppressed = true;
            wb.Navigate("www.google.com");
            wb.Dock = DockStyle.Fill;
            splitContainer1.Panel2.Controls.Add(wb);
            return wb;
        }

        public Form1()
        {

            InitializeComponent();

            wb20 = new Web20();
            rand = new Random(Environment.TickCount);


            List<WebProperties.baseWebProperty> activeSites =  WebProperties.InitWebProperties.init();
            dict = new Dictionary<string,baseWebProperty>();


            foreach (var bp in activeSites)
            {
                bp.logWindow = richTextBox1;
                dict.Add(bp.getLabel(),bp);
                ListViewItem lvi = new ListViewItem(bp.getLabel());
                lvi.Name = bp.getLabel();
                listViewSites.Items.Add(lvi);
            }


           
        }
   

         private void DeleteCookies (WebBrowser wb) 
         {
             System.Diagnostics.Process.Start("rundll32.exe", "InetCpl.cpl,ClearMyTracksByProcess 2");
         }


         private void setupAccount(out ProfileAccount account, String password)
         {
             account = new ProfileAccount();
             AccountEmail email = new AccountEmail();

             email.getRandomEmail("gmail.com");

             account.getRandomString(ref account.username, 9);
             account.getRandomString(ref account.nameFirst, 9);
             account.getRandomString(ref account.nameLast, 9);

             account.password = password;
             account.postalCode = "90210";
             account.city = "Beverly Hills";
             account.stateOrProvince = "CA";
             account.addressFirstLine = "1232 Belevue Ct";
             account.email = email;

             account.challengeQuestion1Answer = "Yourmom";
             
         }

        private void listViewSites_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (listViewSites.SelectedItems.Count < 1)
                return;
            String siteToGoTo =  listViewSites.SelectedItems[0].Name;

           // Web20.PROXYSET(wb20.getProxies()[rand.Next(24)]);
            String sc = listViewSites.SelectedItems[0].Name;

            // Single-threaded while testing with one browser window
                    while (webBrowsers.Count > 0)
                    {
                        splitContainer1.Panel2.Controls.RemoveAt(0);
                        webBrowsers.RemoveAt(0);
                    }
                    webBrowsers.Add(newWebBrowser());
                    ie[0] = new WatiN.Core.DialogHandlers.WebBrowserIE(webBrowsers[0]);
            // Single-threaded while testing with one browser window

            var thread = new System.Threading.Thread(() =>
            {
                WebProperties.ProfileAccount account = new ProfileAccount();
                setupAccount(out account, dict[siteToGoTo].generatePassword(8));
                dict[siteToGoTo].createProfile(ie[0], account);
            });

            // Single-threaded while testing with one browser window
                    while (threadList.Count > 0)
                    {
                        threadList[0].Abort();
                        threadList.RemoveAt(0);
                    }
            // Single-threaded while testing with one browser window

            thread.SetApartmentState(System.Threading.ApartmentState.STA);
            thread.Start();
            threadList.Add(thread);
           }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            foreach (var thread in threadList)
            {
                thread.Abort();
            }
        }
    }
}
