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

        List<Books> bookList = new List<Books>();


        public Form1()
        {
            InitializeComponent();
            
        }

        private void Form1_Load(object sender, EventArgs e)
        {
           
        }


        public void checkForSignIn(IE iebrowser)
        {
            HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();

            s.LoadHtml(iebrowser.Html);

            if (s.DocumentNode.SelectSingleNode("//*[@id='ap_email']") != null)
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
        public bool loadTitles() {
            checkForSignIn(realIE);
            HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();
          
            s.LoadHtml(realIE.Html);

           // HtmlNode l = s.DocumentNode.SelectSingleNode(".//*[@class='tradein-whiteBoxInner']");

            HtmlNodeCollection rows = s.DocumentNode.SelectNodes(".//*[contains(@id, 'order_info_OPEN')]");

            if (rows == null)
                return false;


            Int32 pageNumber = Convert.ToInt32(System.Text.RegularExpressions.Regex.Match(s.DocumentNode.SelectSingleNode(".//*[@id='page_count']").InnerText, "Page (\\d{1,2})").Groups[1].Value);
            foreach (HtmlNode row in rows )
            {
                HtmlNode l2 = row.SelectSingleNode(".//*[@class='title-box']");

                if (l2 == null)
                    continue;

                Books book = new Books();

                HtmlNodeCollection vals = row.SelectNodes("./td");

              //  HtmlNode n = vals[1].SelectSingleNode(".//a");
                book.title = row.SelectSingleNode(".//*[@class='title-box']").InnerText;
                String val = row.SelectSingleNode(".//*[contains(@id, 'totalExpected')]").InnerText;
                val = val.Substring(1);
                book.tradeInValue_Accepted = Convert.ToDecimal(val);


                HtmlNode goodBook = row.SelectSingleNode(".//*[contains(@id, 'status_OPEN')]");

                if ((System.Text.RegularExpressions.Regex.IsMatch(goodBook.InnerText, "Gift card deposited")) ||
                    (System.Text.RegularExpressions.Regex.IsMatch(goodBook.InnerText, "Returned")))
                    continue;
                
                HtmlNode href1 = row.SelectSingleNode(".//*[contains(@id, 'trackBtn_')]");
                HtmlAttribute att = href1.Attributes["href"];
                String href = att.Value;
                href = "https://www.amazon.com" + href;
                href = System.Text.RegularExpressions.Regex.Replace(href, "&amp;", "&");
                book.urlToTrack = href;

                href1 = row.SelectSingleNode(".//*[contains(@id, 'asinLink_OPEN')]");
                att = href1.Attributes["href"];
                href = att.Value;
              //  href = "https://www.amazon.com" + href;
                href = System.Text.RegularExpressions.Regex.Replace(href, "&amp;", "&");
                book.urlToBook = href;

                href1 = row.SelectSingleNode(".//*[contains(@id, 'printLabel_OPEN')]");
                if (href1 != null)
                {
                    att = href1.Attributes["href"];
                    href = att.Value;
                    href = "https://www.amazon.com" + href;
                    href = System.Text.RegularExpressions.Regex.Replace(href, "&amp;", "&");
                    book.urlToPrint = href;
                }
                else
                    book.urlToPrint = null;

                book.pageNumber = pageNumber;
                bookList.Add(book);
                Int32 index = bookList.Count - 1;

                

                listView1.Invoke(
                  new System.Threading.ThreadStart(delegate
                  {
                      ListViewItem lvi = new ListViewItem(book.title);
                      lvi.Name = index.ToString();
                      lvi.SubItems.Add(book.tradeInValue_Accepted.ToString());
                      lvi.SubItems.Add("-");
                      lvi.SubItems.Add("Processing...");
                      listView1.Items.Add(lvi);
                  }));
            }

            return true;
        }

       

        

        private void doTitlesToolStripMenuItem_Click(object sender, EventArgs e)
        {
            var thread = new System.Threading.Thread(new System.Threading.ThreadStart(getShipping));
            thread.SetApartmentState(System.Threading.ApartmentState.STA);
            thread.Start();
        }

        public void doTradeInCheck()
        {
            Settings.Instance.MakeNewIeInstanceVisible = false;
            Settings.MakeNewIeInstanceVisible = false;
            // ie = new WatiN.Core.DialogHandlers.WebBrowserIE(webBrowser1);
            realIE = new IE("www.amazon.com/gp/tradein/multicondition-your-account");
            //realIESecondary = new IE("www.google.com");

            while (realIE.Html == null)
                System.Threading.Thread.Sleep(1000);

            checkForSignIn(realIE);

            Boolean keepgoing = true;
            while (keepgoing)
            {
                while (realIE.Html == null)
                    System.Threading.Thread.Sleep(1000);

                keepgoing = loadTitles();
                statusStrip1.Items[0].Text = "Total Books: " + bookList.Count.ToString();

                Double value = 0;
                foreach (Books book in bookList)
                    value += Convert.ToDouble(book.tradeInValue_Accepted);

                statusStrip1.Items[1].Text = "Value: $" + value.ToString();

                Element nextPage = realIE.Element("page_next_bottom");
                nextPage.Click();
            }

            
            realIE.Close();
            
        }

        private void Form1_Shown(object sender, EventArgs e)
        {
            var thread = new System.Threading.Thread(new System.Threading.ThreadStart(doTradeInCheck));
            thread.SetApartmentState(System.Threading.ApartmentState.STA);
            thread.Start();
                
        }

        

        public void getShipping()
        {
            Int32 numberBooks = 10;// bookList.Count;

            System.Threading.Thread[] threadPool = new System.Threading.Thread[numberBooks];

            for (int j = 0; j < (bookList.Count) / numberBooks; j++)
            {
                for (int i = 0; i < numberBooks; i++)
                {
                    Books book = bookList[j * numberBooks + i];

                    var thread = new System.Threading.Thread(new System.Threading.ThreadStart(book.checkAllShipped));

                    thread.SetApartmentState(System.Threading.ApartmentState.STA);
                    thread.Start();
                    threadPool[i] = thread;
                }

                for (int i = 0; i < numberBooks; i++)
                {
                    threadPool[i].Join();
                    listView1.Invoke(
                   new System.Threading.ThreadStart(delegate
                   {
                       listView1.Items[Convert.ToString(j * numberBooks + i)].SubItems[2].Text = bookList[j * numberBooks + i].tradeInValue_Current.ToString();
                 
                       listView1.Items[Convert.ToString(j * numberBooks + i)].SubItems[3].Text = bookList[j * numberBooks + i].Shipped ? "Yes" : "No";
                   }));
                }
            }
        }

        private void listView1_DoubleClick(object sender, EventArgs e)
        {
            if (listView1.SelectedItems.Count > 0)
            {
                Settings.MakeNewIeInstanceVisible = true;
                WatiN.Core.IE newIE = new IE(bookList[Convert.ToInt32(listView1.SelectedItems[0].Name)].urlToBook);
                Settings.MakeNewIeInstanceVisible = false;
            }
        }

        private void listView1_KeyUp(object sender, KeyEventArgs e)
        {

            if (e.KeyValue == 'F')
            {
                if (listView1.SelectedItems.Count > 0)
                {
                    Settings.MakeNewIeInstanceVisible = true;
                    WatiN.Core.IE newIE = new IE(bookList[Convert.ToInt32(listView1.SelectedItems[0].Name)].urlToPrint);
                    while (newIE.Html == null)
                        System.Threading.Thread.Sleep(1000);
                   // Element el = newIE.Element(Find.BySelector("#labels-list>div>table>tbody>tr>td>a"));
                    Settings.MakeNewIeInstanceVisible = false;
                   // el.Click();
                }
            }
            else if (e.KeyValue == 'D')
            {
                if (listView1.SelectedItems.Count > 0)
                {
                    Settings.MakeNewIeInstanceVisible = true;
                    WatiN.Core.IE newIE = new IE("https://www.amazon.com/gp/tradein/multicondition-your-account/ref=trdrt_ya_page_" + bookList[Convert.ToInt32(listView1.SelectedItems[0].Name)].pageNumber.ToString() + "?ie=UTF8&orderFilter=all&page=" + bookList[Convert.ToInt32(listView1.SelectedItems[0].Name)].pageNumber.ToString());
                    while (newIE.Html == null)
                        System.Threading.Thread.Sleep(1000);
                    // Element el = newIE.Element(Find.BySelector("#labels-list>div>table>tbody>tr>td>a"));
                    Settings.MakeNewIeInstanceVisible = false;
                    // el.Click();
                }
            }
        }

    }
}
