using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;

namespace SEOcommon
{
    public static class Spinner
    {
        private static Random rnd = new Random();
        public static string Spin(string str)
        {
            string betterRegex = @"{
	                                    (?>
		                                    (?! { | } ) .
	                                    |
		                                    { (?<Depth>)
	                                    |
		                                    } (?<-Depth>)
	                                    )*
	                                    (?(Depth)(?!))
                                    }";

            string regex = @"\{(.*?)\}";
            return Regex.Replace(str, betterRegex, new MatchEvaluator(WordScrambler));
        }
        public static string WordScrambler(Match match)
        {
            string[] items = match.Value.Substring(1, match.Value.Length - 2).Split('|');
            return items[rnd.Next(items.Length)];
        }
    }
}
