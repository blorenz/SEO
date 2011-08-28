using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace WebTwoOh
{
    public class ElementWrap
    {
        public WatiN.Core.Element el;
        public Int32 type;

        public ElementWrap(WatiN.Core.Element a, Int32 b)
        {
            el = a;
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


        public const Int32 ACTSELECT = 0;
        public const Int32 ACTENTERTEXT = 1;
        public const Int32 ACTCLICK = 2;
        public const Int32 ACTSWITCH = 3;
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


        public const String ACTSELECT = "SELECT";
        public const String ACTENTERTEXT = "TYPE";
        public const String ACTCLICK = "CLICK";
        public const String ACTSWITCH = "SWITCH";

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

           
            String[] outputString = null;

            if (action == Commands.ACTSELECT)
            {
                outputString = new String[5];
                outputString[0] = action.ToString();

                if (temp[1].CompareTo(StringCommands.BYID) == 0)
                    outputString[1] = Commands.BYID.ToString();
                else if (temp[1].CompareTo(StringCommands.BYCLASS) == 0)
                    outputString[1] = Commands.BYCLASS.ToString();
                else if (temp[1].CompareTo(StringCommands.BYCSS) == 0)
                    outputString[1] = Commands.BYCSS.ToString();
                else if (temp[1].CompareTo(StringCommands.BYTEXT) == 0)
                    outputString[1] = Commands.BYTEXT.ToString();
                else if (temp[1].CompareTo(StringCommands.BYNAME) == 0)
                    outputString[1] = Commands.BYNAME.ToString();

                if (temp[2].CompareTo(StringCommands.ELTEXTFIELD) == 0)
                    outputString[2] = Commands.ELTEXTFIELD.ToString();
                else if (temp[2].CompareTo(StringCommands.ELLINK) == 0)
                    outputString[2] = Commands.ELLINK.ToString();
                else if (temp[2].CompareTo(StringCommands.ELFRAME) == 0)
                    outputString[2] = Commands.ELFRAME.ToString();


                outputString[3] = temp[3];


                //OPTIONAL LABEL
                if (temp.Length > 4)
                    outputString[4] = temp[4];

            }
            else if (action == Commands.ACTCLICK)
            {
                outputString = new String[2];
                outputString[0] = action.ToString();
                outputString[1] = temp[1];

            }
            else if (action == Commands.ACTSWITCH)
            {
                outputString = new String[2];
                outputString[0] = action.ToString();
                outputString[1] = temp[1];

            }
            else if (action == Commands.ACTENTERTEXT)
            {
                outputString = new String[2];
                outputString[0] = action.ToString();

            }
            

           



            return outputString;
         }


    }
}
