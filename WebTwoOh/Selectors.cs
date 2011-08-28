using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;

namespace WebTwoOh
{
    public partial class Form1 : System.Windows.Forms.Form
    {
        private WatiN.Core.Link findByLinkText(String text, WatiN.Core.Frame p)
        {
            WatiN.Core.Link el = p.Link(Find.ByText(text));

            return el;
        }

        private WatiN.Core.Element findById(String text, WatiN.Core.Frame p)
        {
            return p.Element(Find.ById(text));
        }

        private WatiN.Core.Element findByClass(String text, WatiN.Core.Frame p)
        {
            return p.Element(Find.ByClass(text));
        }

        private WatiN.Core.Element findBySelector(String text, WatiN.Core.Frame p)
        {
            return p.Element(Find.BySelector(text));
        }

        private WatiN.Core.Element findByName(String text, WatiN.Core.Frame p)
        {
            return p.Element(Find.ByName(text));
        }

        private WatiN.Core.Element findByValue(String text, WatiN.Core.Frame p)
        {
            return p.Element(Find.ByValue(text));
        }

        private WatiN.Core.TextField findTFById(String text, WatiN.Core.Frame p)
        {
            return p.TextField(Find.ById(text));
        }

        private WatiN.Core.Link findByLinkText(String text, WatiN.Core.Browser p)
        {
            WatiN.Core.Link el = p.Link(Find.ByText(text));

            return el;
        }

        private WatiN.Core.Element findById(String text, WatiN.Core.Browser p)
        {
            return p.Element(Find.ById(text));
        }

        private WatiN.Core.TextField findTFById(String text, WatiN.Core.Browser p)
        {
            return p.TextField(Find.ById(text));
        }


        private WatiN.Core.Element findByClass(String text, WatiN.Core.Browser p)
        {
            return p.Element(Find.ByClass(text));
        }

        private WatiN.Core.Element findBySelector(String text, WatiN.Core.Browser p)
        {
            return p.Element(Find.BySelector(text));
        }

        private WatiN.Core.Element findByName(String text, WatiN.Core.Browser p)
        {
            return p.Element(Find.ByName(text));
        }

        private WatiN.Core.Element findByValue(String text, WatiN.Core.Browser p)
        {
            return p.Element(Find.ByValue(text));
        }

        private WatiN.Core.Frame getFrameFromId(String text, WatiN.Core.Browser p)
        {
            return p.Frame(Find.ById(text));
        }

        private WatiN.Core.Frame getFrameFromId(String text, WatiN.Core.Frame p)
        {
            return p.Frame(Find.ById(text));
        }
    }
}
