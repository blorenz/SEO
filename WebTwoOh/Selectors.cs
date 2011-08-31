using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;

namespace WebTwoOh
{
    public partial class Form1 : System.Windows.Forms.Form
    {
        private WatiN.Core.Link findByLinkText(String text, WatiN.Core.Document p)
        {
            WatiN.Core.Link el = p.Link(Find.ByText(text));

            return el;
        }

        private WatiN.Core.Link findByLinkId(String text, WatiN.Core.Document p)
        {
            WatiN.Core.Link el = p.Link(Find.ById(text));

            return el;
        }

        private WatiN.Core.Div findByDivId(String text, WatiN.Core.Document p)
        {
            WatiN.Core.Div el = p.Div(Find.ById(text));

            return el;
        }

        private WatiN.Core.Button findByButtonId(String text, WatiN.Core.Document p)
        {
            WatiN.Core.Button el = p.Button(Find.ById(text));

            return el;
        }

        private WatiN.Core.Button findByButtonText(String text, WatiN.Core.Document p)
        {
            WatiN.Core.Button el = p.Button(Find.ByText(text));

            return el;
        }

        private WatiN.Core.Element findById(String text, WatiN.Core.Document p)
        {
            return p.Element(Find.ById(text));
        }

        private WatiN.Core.Frame findFrameById(String text, WatiN.Core.Document p)
        {
            return p.Frame(Find.ById(text));
        }


        private WatiN.Core.Element findByClass(String text, WatiN.Core.Document p)
        {
            return p.Element(Find.ByClass(text));
        }

        private WatiN.Core.Element findBySelector(String text, WatiN.Core.Document p)
        {
            return p.Element(Find.BySelector(text));
        }

        private WatiN.Core.Element findByName(String text, WatiN.Core.Document p)
        {
            return p.Element(Find.ByName(text));
        }

        private WatiN.Core.Element findByText(String text, WatiN.Core.Document p)
        {
            return p.Element(Find.ByText(text));
        }

        private WatiN.Core.Element findByValue(String text, WatiN.Core.Document p)
        {
            return p.Element(Find.ByValue(text));
        }


        private WatiN.Core.TextField findTFById(String text, WatiN.Core.Document p)
        {
            return p.TextField(Find.ById(text));
        }
     
        private WatiN.Core.Frame getFrameFromId(String text, WatiN.Core.Document p)
        {
            return p.Frame(Find.ById(text));
        }


        private void typeText(String text, WatiN.Core.TextField p)
        {
            p.TypeText(text);
        }

        private void selectList(String text, WatiN.Core.SelectList p)
        {
            p.Option(text).Select();

        }
    }
}
