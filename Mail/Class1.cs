using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Mail
{
    public class Mail
    {
        static Chilkat.MailMan mailman = new Chilkat.MailMan();
        static bool inited = false;

        public static bool init() {
        //  Any string argument automatically begins the 30-day trial.
        bool success;
        return mailman.UnlockComponent("JINGWEMAILQ_tp6gXy5G9RoQ");
        }


        public static List<WebProperties.Email> getHeaders(ref WebProperties.AccountEmail email) {
           
            if (!inited)
                inited = init();

            //  Set the GMail account POP3 properties.
            mailman.MailHost = email.mailhost;
            mailman.PopUsername = email.emailLogin;
            mailman.PopPassword = email.emailPassword;
            mailman.PopSsl = true;
            mailman.MailPort = email.mailport;

            Chilkat.EmailBundle bundle = null;
            //  Read mail headers and one line of the body.
            //  To get the full emails, call CopyMail instead (no arguments)
            bundle = mailman.GetAllHeaders(1);

            if (bundle == null)
            {
                return null;
            }

            List<WebProperties.Email> emails = new List<WebProperties.Email>();
            int i;
            Chilkat.Email anEmail = null;
            for (i = 0; i <= bundle.MessageCount - 1; i++)
            {
                anEmail = bundle.GetEmail(i);

                //  Display the From email address and the subject.
                WebProperties.Email em = new WebProperties.Email();

                em.from = anEmail.From;
                em.subject = anEmail.Subject;

                emails.Add(em);
            }


            return emails;

        }


    }
}
