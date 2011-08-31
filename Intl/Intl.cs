using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace Intl
{
    public class StringTable
    {
        public Dictionary<String, String> dictStrings = new Dictionary<string,string>();

        public StringTable(String filename)
        {
            TextReader tr = new StreamReader(filename);
            String stringOfStrings = tr.ReadToEnd();
            tr.Close();

            String[] strings = stringOfStrings.Trim().Split('\n');

            foreach (var line in strings)
            {
                String[] pq = line.Trim().Split(',');
                dictStrings.Add(pq[0].Trim(), pq[1].Trim());
            }

        }

    }
}
