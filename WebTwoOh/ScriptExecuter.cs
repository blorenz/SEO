using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace WebTwoOh
{
    public class ElementWrap
    {
        public WatiN.Core.Element el = null;
        public WatiN.Core.Document doc = null;
        public WatiN.Core.TextField tf = null;
        public Int32 type;

        public ElementWrap(WatiN.Core.Element a, Int32 b)
        {
            el = a;
            type = b;
        }

        public ElementWrap(WatiN.Core.Element a, Int32 b, WatiN.Core.TextField c)
        {
            el = a;
            type = b;
            tf = c;
        }

        public ElementWrap(WatiN.Core.Document a, Int32 b)
        {
            doc = a;
            type = b;
        }
    }

    public class Commands
    {
        public const Int32 BYID = 0;
        public const Int32 BYNAME = 1;
        public const Int32 BYCLASS = 2;
        public const Int32 BYCSS = 3;
        public const Int32 BYTEXT = 4;

        public const Int32 ELTEXTFIELD = 0;
        public const Int32 ELLINK = 1;
        public const Int32 ELFRAME = 2;
        public const Int32 ELBUTTON = 3;
        public const Int32 ELDIV = 4;


        public const Int32 ACTSELECT = 0;
        public const Int32 ACTENTERTEXT = 1;
        public const Int32 ACTCLICK = 2;
        public const Int32 ACTSWITCH = 3;
        public const Int32 ACTSELECTLIST = 4;
    }

    public class StringCommands
    {
        public const String BYID = "ID";
        public const String BYNAME = "NAME";
        public const String BYCLASS = "CLASS";
        public const String BYCSS = "CSS";
        public const String BYTEXT = "TEXT";

        public const String ELTEXTFIELD = "TEXTFIELD";
        public const String ELLINK = "LINK";
        public const string ELFRAME = "FRAME";
        public const string ELBUTTON = "BUTTON";
        public const string ELDIV = "DIV";


        public const String ACTSELECT = "SELECT";
        public const String ACTENTERTEXT = "TYPETEXT";
        public const String ACTCLICK = "CLICK";
        public const String ACTSWITCH = "SWITCH";
        public const String ACTSELECTLIST = "SELECTLIST";

    }

    public class ScriptExecuter
    {
        String[] loadedScript = null;
        Int32 inc = 0;
        public ScriptExecuter()
        {

        }

        public bool loadScript(String scriptName)
        {
            TextReader tr = new StreamReader(scriptName);

            String str = tr.ReadToEnd();

            loadedScript =  str.Trim().Split('\n');

            return true;
        }

        public String[] parseLine(String line)
        {
            return line.Trim().Split('/');
        }

        public String getSelectorType(String comp)
        {

            if (comp.CompareTo(StringCommands.BYID) == 0)
                   return Commands.BYID.ToString();
            else if (comp.CompareTo(StringCommands.BYCLASS) == 0)
                return Commands.BYCLASS.ToString();
            else if (comp.CompareTo(StringCommands.BYCSS) == 0)
                return Commands.BYCSS.ToString();
            else if (comp.CompareTo(StringCommands.BYTEXT) == 0)
                return Commands.BYTEXT.ToString();
            else if (comp.CompareTo(StringCommands.BYNAME) == 0)
                return Commands.BYNAME.ToString();

            return "";

        }

        public String getElementType(String comp)
        {
            if (comp.CompareTo(StringCommands.ELTEXTFIELD) == 0)
                return Commands.ELTEXTFIELD.ToString();
            else if (comp.CompareTo(StringCommands.ELLINK) == 0)
                return Commands.ELLINK.ToString();
            else if (comp.CompareTo(StringCommands.ELFRAME) == 0)
                return  Commands.ELFRAME.ToString();
            else if (comp.CompareTo(StringCommands.ELBUTTON) == 0)
                return Commands.ELBUTTON.ToString();
            else if (comp.CompareTo(StringCommands.ELDIV) == 0)
                return Commands.ELDIV.ToString();
            return "";


        }
        public String[] getNext()
        {
            if (inc >= loadedScript.Length)
                return null;

            String[] temp = loadedScript[inc++].Trim().Split('/');

            Int32 action = -1;
            if (temp[0].CompareTo(StringCommands.ACTSELECT) == 0)
                action = Commands.ACTSELECT;
            else if (temp[0].CompareTo(StringCommands.ACTCLICK) == 0)
                action = Commands.ACTCLICK;
            else if (temp[0].CompareTo(StringCommands.ACTENTERTEXT) == 0)
                action = Commands.ACTENTERTEXT;
            else if (temp[0].CompareTo(StringCommands.ACTSWITCH) == 0)
                action = Commands.ACTSWITCH;
            else if (temp[0].CompareTo(StringCommands.ACTSELECTLIST) == 0)
                action = Commands.ACTSELECTLIST;

           
            String[] outputString = null;

            if (action == Commands.ACTSELECT)
            {
                outputString = new String[5];
                outputString[0] = action.ToString();

              
               outputString[1] = getSelectorType(temp[1]);
                
                
                outputString[2] = getElementType(temp[2]);
               


                outputString[3] = temp[3];


                //OPTIONAL LABEL
                if (temp.Length > 4)
                    outputString[4] = temp[4];

            }
            else if (action == Commands.ACTCLICK)
            {
                outputString = new String[4];
                outputString[0] = action.ToString();
                outputString[1] = getSelectorType(temp[1]);

                outputString[2] = getElementType(temp[2]);

                outputString[3] = temp[3];

            }
            else if (action == Commands.ACTSWITCH)
            {
                outputString = new String[2];
                outputString[0] = action.ToString();
                outputString[1] = temp[1];

            }
            else if (action == Commands.ACTENTERTEXT)
            {
                outputString = new String[4];
                outputString[0] = action.ToString();

                outputString[1] = getSelectorType(temp[1]);
                

                outputString[2] = temp[2];
                outputString[3] = temp[3];

            }
            else if(action == Commands.ACTSELECTLIST)
            {
                 outputString = new String[4];
                outputString[0] = action.ToString();


                outputString[1] = getSelectorType(temp[1]);

                outputString[2] = temp[2];
                outputString[3] = temp[3];
            }
            

           



            return outputString;
         }


    }
}
