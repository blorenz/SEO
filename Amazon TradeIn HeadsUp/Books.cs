using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using HtmlAgilityPack;

namespace Amazon_TradeIn_HeadsUp
{
    public class Books
    {
       public String urlToBook;
       public String title;
       public String urlToTradeIn;
       public String urlToPrint;
       public String urlToTrack;
       public Decimal tradeInValue_Accepted;
       public Decimal tradeInValue_Current;
       public Boolean Shipped;
       public Int32 pageNumber;

       public IE IESecondary = null;

       public void checkAllShipped()
       {
           
           Books book = this;


           try
           {
               IESecondary = new IE();
               IESecondary.GoTo(book.urlToTrack);
           }

           catch
           {

           }
           while (IESecondary.Html == null)
               System.Threading.Thread.Sleep(1000);
           System.Threading.Thread.Sleep(1000);
           Boolean didShip = checkIfIShipped(IESecondary);
           book.Shipped = didShip;
           // listView1.Items[Convert.ToString(i)].SubItems[1].Text = 
         
           // book.Shipped = didShip;
           getSellPrice(IESecondary);
           IESecondary.Close();
       }

       public Boolean checkIfIShipped(WatiN.Core.IE nextbrowser)
       {
           HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();
           s.LoadHtml(nextbrowser.Html);

           HtmlNode l = s.DocumentNode.SelectSingleNode(".//*[@class='tradein-cBoxInner']/table//table");

           if (l == null)
               return false;

           HtmlNodeCollection els = l.SelectNodes(".//tr");

           if (els.Count > 2)
               return true;

           return false;
       }

        public void getSellPrice()
        {
    
            IESecondary = new IE(urlToBook);
            while (IESecondary.Html == null)
                System.Threading.Thread.Sleep(1000);
            HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();

            s.LoadHtml(IESecondary.Html);
            HtmlNode n = null;
            n = s.DocumentNode.SelectSingleNode("//*[@class='qpHeadline']");
            if ( n != null) {

                System.Text.RegularExpressions.Regex re = new System.Text.RegularExpressions.Regex("\\$?(\\d*\\.\\d{2})");

                System.Text.RegularExpressions.Match match = re.Match(n.InnerText);

                tradeInValue_Current = Convert.ToDecimal(match.Groups[1].Value);
            }

        }

        public void getSellPrice(IE ieSecondary)
        {

            ieSecondary.GoTo(urlToBook);
            while (ieSecondary.Html == null)
                System.Threading.Thread.Sleep(1000);
            HtmlAgilityPack.HtmlDocument s = new HtmlAgilityPack.HtmlDocument();

            s.LoadHtml(ieSecondary.Html);
            HtmlNode n = null;
            n = s.DocumentNode.SelectSingleNode("//*[@class='qpHeadline']");
            if (n != null)
            {

                System.Text.RegularExpressions.Regex re = new System.Text.RegularExpressions.Regex("\\$?(\\d*\\.\\d{2})");

                System.Text.RegularExpressions.Match match = re.Match(n.InnerText);

                tradeInValue_Current = Convert.ToDecimal(match.Groups[1].Value);
            }

        }
    }
}
