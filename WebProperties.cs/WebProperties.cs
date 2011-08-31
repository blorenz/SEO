using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WatiN.Core;
using System.IO;


namespace WebProperties
{
    public static class CharacterSets
    {
        public static String lowercase = "abcdefghijklmnopqrstuvwxyz";
        public static String uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        public static string numbers = "01234567890";
        public static string symbols = "!@#$%^&*()";
    }

    public class AccountEmail
    {
        public String emailAddress = "";
        public String emailPassword = "";

        Random rand = new Random(Environment.TickCount);

        public String getRandomEmail(String domain, Int32 maxLength = 10)
        {
            emailAddress = "";
            String sets = CharacterSets.lowercase + CharacterSets.uppercase + CharacterSets.numbers;
            for (int i = 0; i < maxLength; i++)
                emailAddress += sets[rand.Next(sets.Length)];
            emailAddress += "@" + domain;
            return emailAddress;
        }
    }

    public class Month
    {
        Int32 month = 1;

        public String getString()
        {
            switch (month)
            {
                case 1: return "January";
                case 2: return "February";
                case 3: return "March";
                case 4: return "April";
                case 5: return "May";
                case 6: return "June";
                case 7: return "July";
                case 8: return "August";
                case 9: return "September";
                case 10: return "October";
                case 11: return "November";
                default: return "December";


            }
        }

    }

    public class ProfileAccount
    {
        public String nameFirst = "";
        public String nameLast = "";
        public String addressFirstLine = "";
        public String addressSecondLine = "";
        public String city = "";
        public String stateOrProvince = "";
        public String postalCode = "";

        public Month birthMonth = new Month();
        public Int32 birthDay = 1;
        public Int32 birthYear = 1979;

        public String username = "";
        public String password = "";

        public AccountEmail email = null;

        public Boolean genderMale = true;


        public String challengeQuestion1 = "";
        public String challengeQuestion1Answer = "";
        public String challengeQuestion2 = "";
        public String challengeQuestion2Answer = "";
        public String challengeQuestion3 = "";
        public String challengeQuestion3Answer = "";


        Random rand = new Random(Environment.TickCount);

        public String getRandomString(ref String str, Int32 maxLength = 10)
        {
            str = "";
            String sets = CharacterSets.lowercase + CharacterSets.uppercase + CharacterSets.numbers;
            for (int i = 0; i < maxLength; i++)
                str += sets[rand.Next(sets.Length)];
            return str;
        }
    }

    public static class InitWebProperties {

        public static Intl.StringTable stringTable = null;

        public static List<baseWebProperty> init()
        {
            stringTable = new Intl.StringTable("./strings.txt");
            List< baseWebProperty> dict = new List<baseWebProperty>();

            dict.Add(new com.Angelfire());
            dict.Add(new com.Beep());
            dict.Add(new com.BlinkWeb());
            dict.Add(new com.Blog());

            return dict;
        }
    }

    public static class CaptchaSolving
    {
        public static String solveDeathByCaptcha(String href)
        {
            System.Net.WebClient wc = new System.Net.WebClient();
            byte[] buffer = wc.DownloadData(href);

            DeathByCaptcha.Client client = (DeathByCaptcha.Client)new DeathByCaptcha.SocketClient("coding.solo", "colonel1");
            try
            {

                /* Put your CAPTCHA file name, or file object, or arbitrary stream,
                   or an array of bytes, and optional solving timeout (in seconds) here: */
                DeathByCaptcha.Captcha captcha = client.Decode(buffer);
                if (null != captcha)
                {
                    /* The CAPTCHA was solved; captcha.Id property holds its numeric ID,
                       and captcha.Text holds its text. */
                    return captcha.Text;
                }
            }
            catch (DeathByCaptcha.AccessDeniedException e)
            {
                /* Access to DBC API denied, check your credentials and/or balance */
                return null;
            }

            return null;
        }
    }

    public class baseWebProperty {

        Random rand = new Random(Environment.TickCount);

        public System.Windows.Forms.RichTextBox logWindow = null;

        public void logMessage(Int32 level, String key, params object[] args)
        {
            if (logWindow != null)
            {
                if (InitWebProperties.stringTable.dictStrings.ContainsKey(key))
                {
                    String msg = InitWebProperties.stringTable.dictStrings[key];
                    String newMsg = null;
                    if (args != null)
                        newMsg = String.Format(msg, args);
                    else
                        newMsg = msg;

                    System.Windows.Forms.MethodInvoker action = delegate
                    { logWindow.Text += newMsg + "\n"; };
                    logWindow.BeginInvoke(action);
                }
              }
         }


        public String generatePassword(int length) {
            String str = "";

            for (int i = 0; i < length; i++)
                str += getPasswordChars()[rand.Next(getPasswordChars().Length)];
            return str;
        }

        public virtual String getPasswordChars()
        {
            return CharacterSets.lowercase + CharacterSets.uppercase + CharacterSets.numbers;
        }

        public virtual void createProfile(WatiN.Core.IE window, ProfileAccount account)
        {
        }

        public virtual String getSiteDomain()
        {
            return "";
        }

        public virtual String getLabel()
        {
            return "";
        }

      

    }

    namespace com
    {
        public class Angelfire : baseWebProperty
        {
            public override String getSiteDomain()
            {
                return "angelfire.com";
            }

            public override String getLabel()
            {
                return "angelfire.com";
            }

            public override void createProfile(WatiN.Core.IE window, ProfileAccount account)
            {
                logMessage(0, "LOG_CONNECT_TO", getLabel());
                // Windows
                window.ClearCookies("http://" + getSiteDomain());
                window.ClearCookies("http://lycos.com");
                window.GoTo("http://" +getSiteDomain());
             

               // window.Eval("void((function(){var a,b,c,e,f;f=0;a=document.cookie.split('; ');for(e=0;e<a.length&&a[e];e++){f++;for(b='.'+location.host;b;b=b.replace(/^(?:%5C.|[^%5C.]+)/,'')){for(c=location.pathname;c;c=c.replace(/.$/,'')){document.cookie=(a[e]+'; domain='+b+'; path='+c+'; expires='+new Date((new Date()).getTime()-1e11).toGMTString());}}}})())");
                // Frames

                // Model
                Link lnk_wwwangelfirelycoscomauthpromom_CYCLE4 = window.Link(Find.ByUrl("http://www.angelfire.lycos.com/auth/promo?m_CYCLE=4"));
                lnk_wwwangelfirelycoscomauthpromom_CYCLE4.Click();
                WatiN.Core.Frame frame = window.Frame(Find.ById("windowbox-content"));
                Element __next1 = frame.Element(Find.ById("next1"));
                TextField txt_m_U = frame.TextField(Find.ByName("m_U"));
                TextField txt_m_P = frame.TextField(Find.ByName("m_P"));
                TextField txt_m_PASSVERIFY = frame.TextField(Find.ByName("m_PASSVERIFY"));
                TextField txt_m_EMAIL = frame.TextField(Find.ByName("m_EMAIL"));
                TextField txt_m_ANSWER = frame.TextField(Find.ByName("m_ANSWER"));
                Element __confirm = frame.Element(Find.ById("confirm"));

                // Code


                txt_m_U.TypeText(account.username);

                txt_m_P.TypeText(account.password);
                txt_m_PASSVERIFY.TypeText(account.password);

                txt_m_EMAIL.TypeText(account.email.emailAddress);
                
                __next1.Click();
                Element __next2 = frame.Element(Find.ById("next2"));
                __next2.Click();
                frame.SelectList("m_BIRTHMONTH").Option(account.birthMonth.getString()).Select();
                frame.SelectList("m_BIRTHDAY").Option(account.birthDay.ToString()).Select();
                frame.SelectList("m_BIRTHYEAR").Option(account.birthYear.ToString()).Select();
                txt_m_ANSWER.TypeText(account.challengeQuestion1Answer);
                frame.SelectList("m_GENDER").Option(account.genderMale ? "Male" : "Female").Select();
                __confirm.Click();
            }
        }

        public class Beep : baseWebProperty
        {
            public override String getSiteDomain()
            {
                return "beep.com";
            }

            public override string getPasswordChars()
            {
                return CharacterSets.lowercase + CharacterSets.numbers;
            }
            public override String getLabel()
            {
                return "beep.com";
            }

            public override void createProfile(IE window, ProfileAccount account)
            {
                window.ClearCookies("http://" + getSiteDomain());
                window.GoTo("http://" + getSiteDomain());
             
                // Frames

                // Model
                Link lnk_wwwbeepcomsignuphtmlaccount_typehomepagejumptosignup______ = window.Link(Find.ByUrl("http://www.beep.com/signup.html?account_type=homepage&jumpto=signup"));
                TextField txt_username = window.TextField(Find.ByName("username"));
                TextField txt_name = window.TextField(Find.ByName("name"));
                TextField txt_email = window.TextField(Find.ByName("email"));
                TextField txt_password = window.TextField(Find.ByName("password"));
                CheckBox chk_tac_signup_tac = window.CheckBox(Find.ByName("tac") && Find.ById("signup_tac"));
                Button btn_btn_submit = window.Button(Find.ById("btn_submit"));
                TextField txt_recaptcha_response_field = window.TextField(Find.ByName("recaptcha_response_field"));
                Button btn_Signupnow = window.Button(Find.ByValue("Sign up now"));

                // Code
                lnk_wwwbeepcomsignuphtmlaccount_typehomepagejumptosignup______.Click();
                txt_username.TypeText(account.username);
                txt_name.TypeText(account.nameFirst + " " + account.nameLast);
                txt_email.TypeText(account.email.emailAddress);
                txt_password.TypeText(account.password);
                chk_tac_signup_tac.Checked = true;
                btn_btn_submit.Click();
                //Decaptcher

                while (true)
                {
                    Div div = window.Div("recaptcha_image");
                    Image img = div.Image(Find.First());

                    logMessage(0, "LOG_SOLVING_CAPTCHA", null);
                    String captchaText = CaptchaSolving.solveDeathByCaptcha(img.Src);
                    logMessage(0, "LOG_SOLVED_CAPTCHA", captchaText);

                    if (captchaText != null)
                    {
                        txt_recaptcha_response_field.Click();
                        txt_recaptcha_response_field.TypeText(captchaText);
                        btn_Signupnow.Click();
                    }
                    if (!window.Elements.Exists("recaptcha_image"))
                        break;

                }
             

            }
        }

        public class BlinkWeb : baseWebProperty
        {
            public override String getSiteDomain()
            {
                return "blinkweb.com";
            }

            public override string getPasswordChars()
            {
                return CharacterSets.lowercase + CharacterSets.numbers;
            }
            public override String getLabel()
            {
                return "blinkweb.com";
            }

            public override void createProfile(IE window, ProfileAccount account)
            {
                window.ClearCookies("http://" + getSiteDomain());
                window.GoTo("http://" + getSiteDomain());
                
                // Frames

                // Model 
                // Frames

                // Model
                TextField txt_user_name = window.TextField(Find.ByName("user_name"));
                TextField txt_user_pass = window.TextField(Find.ByName("user_pass"));
                TextField txt_user_email = window.TextField(Find.ByName("user_email"));
                CheckBox chk_create_agree_create_agree = window.CheckBox(Find.ByName("create_agree") && Find.ById("create_agree"));
                Div div_createAccount = window.Div(Find.ById("createAccount"));

                // Code
             
                txt_user_name.TypeText(account.username);
                txt_user_pass.TypeText(account.password);
                txt_user_email.TypeText(account.email.emailAddress);
                chk_create_agree_create_agree.Checked = true;
                div_createAccount.Click();


            }
        }


          public class Blog : baseWebProperty
        {
            public override String getSiteDomain()
            {
                return "blog.com";
            }

            public override string getPasswordChars()
            {
                return CharacterSets.lowercase + CharacterSets.numbers;
            }
            public override String getLabel()
            {
                return "blog.com";
            }

            public override void createProfile(IE window, ProfileAccount account)
            {
                window.ClearCookies("http://" + getSiteDomain());
                window.GoTo("http://" + getSiteDomain());
                // Frames

                // Model
                Link spn______ = window.Link(Find.ByUrl("http://blog.com/wp-signup.php"));
                TextField txt_user_email = window.TextField(Find.ByName("user_email"));
                TextField txt_password_1 = window.TextField(Find.ByName("password_1"));
                TextField txt_password_2 = window.TextField(Find.ByName("password_2"));
                TextField txt_recaptcha_response_field = window.TextField(Find.ByName("recaptcha_response_field"));
                Button btn_submit_btn = window.Button(Find.ByName("submit_btn"));
                TextField txt_blogname = window.TextField(Find.ByName("blogname"));
                Span spn_ = window.Span(Find.ByText(""));
                TextField txt_blog_title = window.TextField(Find.ByName("blog_title"));
                RadioButton button = window.RadioButton(Find.ById("signupuser"));

                // Code
                spn______.Click();
                txt_user_email.TypeText(account.email.emailAddress);
                txt_password_1.TypeText(account.password);
                txt_password_2.TypeText(account.password);

                while (true)
                {
                    Div div = window.Div("recaptcha_image");
                    Image img = div.Image(Find.First());

                    logMessage(0, "LOG_SOLVING_CAPTCHA", null);
                    String captchaText = CaptchaSolving.solveDeathByCaptcha(img.Src);
                    logMessage(0, "LOG_SOLVED_CAPTCHA", captchaText);

                    if (captchaText != null)
                    {
                        txt_recaptcha_response_field.Click();
                        txt_recaptcha_response_field.TypeText(captchaText);
                        button.Checked = true;
                        btn_submit_btn.Click();
                    }
                    if (!window.Elements.Exists("recaptcha_image"))
                        break;

                }
              
             
            }
        }
    }

    namespace net
    {
   

    }

    namespace org
    {

    }
}
