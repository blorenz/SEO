using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using System.Runtime.InteropServices;

namespace WebTwoOh
{
    class Web20
    {
        TextReader trdr = null;

        String[] sites = null;

        String[] proxies = null;

        public Web20()
        {
            trdr = new StreamReader("./proxies.txt");
            String input = trdr.ReadToEnd();

            trdr.Close();

            proxies = input.Trim().Split('\n');

        }

        public String[] getSites()
        {
            return sites;
        }

        public String[] getProxies()
        {
            return proxies;
        }


         public struct Struct_INTERNET_PROXY_INFO {
          public Int32 dwAccessType;
          public IntPtr proxy;
          public IntPtr proxyBypass;
  }

    [DllImport("wininet.dll", SetLastError = true, CharSet=CharSet.Auto)]
    public static extern bool InternetSetOption(IntPtr hInternet, int dwOption, IntPtr lpBuffer, int dwBufferLength);

    public static bool PROXYSET(String strProxy) {
 // WebBrowser1.ScriptErrorsSuppressed = True
  const Int32 INTERNET_OPTION_PROXY = 38;
  const Int32 INTERNET_OPEN_TYPE_PROXY = 3;
  Struct_INTERNET_PROXY_INFO struct_IPI;
  struct_IPI.dwAccessType = INTERNET_OPEN_TYPE_PROXY;
  struct_IPI.proxy = System.Runtime.InteropServices.Marshal.StringToHGlobalAnsi(strProxy);
  struct_IPI.proxyBypass = System.Runtime.InteropServices.Marshal.StringToHGlobalAnsi("local");
  IntPtr intptrStruct = System.Runtime.InteropServices.Marshal.AllocCoTaskMem(System.Runtime.InteropServices.Marshal.SizeOf(struct_IPI));
  System.Runtime.InteropServices.Marshal.StructureToPtr(struct_IPI, intptrStruct, true);
  Boolean iReturn = InternetSetOption(IntPtr.Zero, INTERNET_OPTION_PROXY, intptrStruct, System.Runtime.InteropServices.Marshal.SizeOf(struct_IPI));
  return iReturn;
    }
        
    }


   
}
