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
using OpenQA.Selenium.Firefox;
using OpenQA.Selenium;
using Microsoft.Win32;
using System.Net;

namespace WebTwoOh
{
    public partial class Form1 : System.Windows.Forms.Form
    {
        private IWebDriver driver;
        private StringBuilder verificationErrors;
        private string baseURL;
        private WatiN.Core.DialogHandlers.WebBrowserIE ie = null;
        Web20 wb20 = null;
        Random rand = null;
        public Form1()
        {

            InitializeComponent();

            wb20 = new Web20();
            rand = new Random(Environment.TickCount);
            changeProxy(wb20.getProxies()[rand.Next(24)]);
            webBrowser1.ScriptErrorsSuppressed = true;
            webBrowser1.Navigate("www.google.com");
            foreach (String line in wb20.getSites())
            {
                ListViewItem lvi = new ListViewItem(line.Trim());
                //lvi.Text = "dfsdfsdF";
                listViewSites.Items.Add(lvi);
            }
            ie = new WatiN.Core.DialogHandlers.WebBrowserIE(webBrowser1);

        }

        private void changeProxy(String str)
        {
            RegistryKey registry = Registry.CurrentUser.OpenSubKey("Software\\Microsoft\\Windows\\CurrentVersion\\Internet Settings", true);
            registry.SetValue("ProxyEnable", 0);
            registry.SetValue("ProxyServer", str);

        }

        private void listViewSites_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (listViewSites.SelectedItems.Count < 1)
                return;
            String siteToGoTo =  listViewSites.SelectedItems[0].Text;

            //webBrowser1.Navigate("javascript:void((function(){var a,b,c,e,f;f=0;a=document.cookie.split('; ');for(e=0;e<a.length&&a[e];e++){f++;for(b='.'+location.host;b;b=b.replace(/^(?:%5C.|[^%5C.]+)/,'')){for(c=location.pathname;c;c=c.replace(/.$/,'')){document.cookie=(a[e]+'; domain='+b+'; path='+c+'; expires='+new Date((new Date()).getTime()-1e11).toGMTString());}}}})())");

            Web20.PROXYSET(wb20.getProxies()[rand.Next(24)]);
            var thread = new System.Threading.Thread(() =>
            {
                ie.GoTo(siteToGoTo);
            });
            thread.SetApartmentState(System.Threading.ApartmentState.STA);
            thread.Start();           
           }
    }
}
