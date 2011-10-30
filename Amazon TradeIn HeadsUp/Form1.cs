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

namespace Amazon_TradeIn_HeadsUp
{
    public partial class Form1 : System.Windows.Forms.Form
    {

        WatiN.Core.DialogHandlers.WebBrowserIE ie = null;
        WatiN.Core.IE realIE = null;
        WatiN.Core.IE realIESecondary = null;

        public Form1()
        {
            InitializeComponent();
            webBrowser1.ScriptErrorsSuppressed = true;
            
        }

        private void Form1_Load(object sender, EventArgs e)
        {
           
        }

        public WebBrowser newWebBrowser()
        {
            WebBrowser wb = new WebBrowser();
            splitContainer1.Panel2.Controls.Add(wb);
            wb.ScriptErrorsSuppressed = true;
            wb.Navigate("www.amazon.com");
            wb.Dock = DockStyle.Fill;
            
            return wb;
        }

        public void checkForSignIn()
        {
            if (realIE.Elements.Exists("ap_email"))
            {

                Element te = realIE.Element("ap_email");//realIE.TextField("ap_email");
                te.SetAttributeValue("value","blorenz@gmail.com");
                realIE.TextField("ap_password").TypeText("colonel1");
                te = realIE.Element("signInSubmit");
                te.Click();

            }

           // ap_email
            //ap_password
            //signInSubmit
        }
        public void loadTitles() {
            HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();
          
            s.LoadHtml(realIE.Html);

           // HtmlNode l = s.DocumentNode.SelectSingleNode(".//*[@class='tradein-whiteBoxInner']");
            
            foreach (HtmlNode row in s.DocumentNode.SelectNodes(".//*[@class='ti-order']"))
            {
                HtmlNode l2 = row.SelectSingleNode(".//*[@class='title-box']");

                if (l2 == null)
                    continue;

                HtmlNodeCollection vals = row.SelectNodes("./td");

              //  HtmlNode n = vals[1].SelectSingleNode(".//a");
                ListViewItem lvi = new ListViewItem(row.SelectSingleNode(".//*[@class='title-box']").InnerText);

                lvi.SubItems.Add(row.SelectSingleNode(".//*[contains(@id, 'totalExpected')]").InnerText);



                HtmlNode href1 = row.SelectSingleNode(".//*[contains(@id, 'trackBtn_')]");
                HtmlAttribute att = href1.Attributes["href"];
                String href = att.Value;


                href = "https://www.amazon.com" + href;
                href = System.Text.RegularExpressions.Regex.Replace(href, "&amp;", "&");
                try
                {
                    realIESecondary.GoTo(href);
                }
                catch
                {
                    
                }
                while (realIESecondary.Html == null)
                    System.Threading.Thread.Sleep(1000);
                System.Threading.Thread.Sleep(1000);
                Boolean didShip = checkIfIShipped(realIESecondary);

                lvi.SubItems.Add(didShip ? "Yes" : "No");

                listView1.Items.Add(lvi);
            }

        }

        public Boolean checkIfIShipped(WatiN.Core.IE nextbrowser)
        {
            HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();
            s.LoadHtml(nextbrowser.Html);

            HtmlNode l = s.DocumentNode.SelectSingleNode(".//*[@class='tradein-cBoxInner']/table//table");

            HtmlNodeCollection els = l.SelectNodes(".//tr");

            if (els.Count > 2)
                return true;

            return false;
        }

        private void doTitlesToolStripMenuItem_Click(object sender, EventArgs e)
        {
            
        }

        private void Form1_Shown(object sender, EventArgs e)
        {

          // ie = new WatiN.Core.DialogHandlers.WebBrowserIE(webBrowser1);
            realIE = new IE("www.amazon.com/gp/tradein/multicondition-your-account");
            realIESecondary = new IE("www.google.com");

            while (realIE.Html == null)
                System.Threading.Thread.Sleep(1000);

            checkForSignIn();

            while (true)
            {
                while (realIE.Html == null)
                    System.Threading.Thread.Sleep(1000);

                loadTitles();

                Element nextPage = realIE.Element("page_next_bottom");
                nextPage.Click();
            }
        }

    }
}
