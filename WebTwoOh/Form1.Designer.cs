namespace WebTwoOh
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.splitContainerSitesVsBrowsers = new System.Windows.Forms.SplitContainer();
            this.splitContainerSitesVsLog = new System.Windows.Forms.SplitContainer();
            this.tabControlSites = new DevExpress.XtraTab.XtraTabControl();
            this.tabPageSites = new DevExpress.XtraTab.XtraTabPage();
            this.listViewSites = new System.Windows.Forms.ListView();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.xtraTabPage2 = new DevExpress.XtraTab.XtraTabPage();
            this.richTextBox1 = new System.Windows.Forms.RichTextBox();
            this.button1 = new System.Windows.Forms.Button();
            this.listView1 = new System.Windows.Forms.ListView();
            this.columnHeader2 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.button2 = new System.Windows.Forms.Button();
            this.richTextBox3 = new System.Windows.Forms.RichTextBox();
            this.richTextBox2 = new System.Windows.Forms.RichTextBox();
            this.xtraTabControl1 = new DevExpress.XtraTab.XtraTabControl();
            this.xtraTabPage1 = new DevExpress.XtraTab.XtraTabPage();
            this.xtraTabPage3 = new DevExpress.XtraTab.XtraTabPage();
            this.splitContainerControl1 = new DevExpress.XtraEditors.SplitContainerControl();
            this.xtraTabPage4 = new DevExpress.XtraTab.XtraTabPage();
            this.splitContainerControl2 = new DevExpress.XtraEditors.SplitContainerControl();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsBrowsers)).BeginInit();
            this.splitContainerSitesVsBrowsers.Panel1.SuspendLayout();
            this.splitContainerSitesVsBrowsers.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsLog)).BeginInit();
            this.splitContainerSitesVsLog.Panel1.SuspendLayout();
            this.splitContainerSitesVsLog.Panel2.SuspendLayout();
            this.splitContainerSitesVsLog.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.tabControlSites)).BeginInit();
            this.tabControlSites.SuspendLayout();
            this.tabPageSites.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.xtraTabControl1)).BeginInit();
            this.xtraTabControl1.SuspendLayout();
            this.xtraTabPage1.SuspendLayout();
            this.xtraTabPage3.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerControl1)).BeginInit();
            this.splitContainerControl1.SuspendLayout();
            this.xtraTabPage4.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerControl2)).BeginInit();
            this.splitContainerControl2.SuspendLayout();
            this.SuspendLayout();
            // 
            // splitContainerSitesVsBrowsers
            // 
            this.splitContainerSitesVsBrowsers.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainerSitesVsBrowsers.Location = new System.Drawing.Point(0, 0);
            this.splitContainerSitesVsBrowsers.Name = "splitContainerSitesVsBrowsers";
            // 
            // splitContainerSitesVsBrowsers.Panel1
            // 
            this.splitContainerSitesVsBrowsers.Panel1.Controls.Add(this.splitContainerSitesVsLog);
            this.splitContainerSitesVsBrowsers.Size = new System.Drawing.Size(884, 537);
            this.splitContainerSitesVsBrowsers.SplitterDistance = 199;
            this.splitContainerSitesVsBrowsers.TabIndex = 2;
            // 
            // splitContainerSitesVsLog
            // 
            this.splitContainerSitesVsLog.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainerSitesVsLog.Location = new System.Drawing.Point(0, 0);
            this.splitContainerSitesVsLog.Name = "splitContainerSitesVsLog";
            this.splitContainerSitesVsLog.Orientation = System.Windows.Forms.Orientation.Horizontal;
            // 
            // splitContainerSitesVsLog.Panel1
            // 
            this.splitContainerSitesVsLog.Panel1.Controls.Add(this.tabControlSites);
            // 
            // splitContainerSitesVsLog.Panel2
            // 
            this.splitContainerSitesVsLog.Panel2.Controls.Add(this.richTextBox1);
            this.splitContainerSitesVsLog.Size = new System.Drawing.Size(199, 537);
            this.splitContainerSitesVsLog.SplitterDistance = 377;
            this.splitContainerSitesVsLog.TabIndex = 1;
            // 
            // tabControlSites
            // 
            this.tabControlSites.Dock = System.Windows.Forms.DockStyle.Fill;
            this.tabControlSites.Location = new System.Drawing.Point(0, 0);
            this.tabControlSites.LookAndFeel.SkinName = "Caramel";
            this.tabControlSites.LookAndFeel.UseDefaultLookAndFeel = false;
            this.tabControlSites.Name = "tabControlSites";
            this.tabControlSites.SelectedTabPage = this.tabPageSites;
            this.tabControlSites.Size = new System.Drawing.Size(199, 377);
            this.tabControlSites.TabIndex = 1;
            this.tabControlSites.TabPages.AddRange(new DevExpress.XtraTab.XtraTabPage[] {
            this.tabPageSites,
            this.xtraTabPage2});
            // 
            // tabPageSites
            // 
            this.tabPageSites.Controls.Add(this.listViewSites);
            this.tabPageSites.Name = "tabPageSites";
            this.tabPageSites.Size = new System.Drawing.Size(192, 349);
            this.tabPageSites.Text = "Sites";
            // 
            // listViewSites
            // 
            this.listViewSites.CheckBoxes = true;
            this.listViewSites.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1});
            this.listViewSites.Dock = System.Windows.Forms.DockStyle.Fill;
            this.listViewSites.Location = new System.Drawing.Point(0, 0);
            this.listViewSites.Name = "listViewSites";
            this.listViewSites.Size = new System.Drawing.Size(192, 349);
            this.listViewSites.TabIndex = 0;
            this.listViewSites.UseCompatibleStateImageBehavior = false;
            this.listViewSites.View = System.Windows.Forms.View.Details;
            this.listViewSites.SelectedIndexChanged += new System.EventHandler(this.listViewSites_SelectedIndexChanged);
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "Site";
            this.columnHeader1.Width = 400;
            // 
            // xtraTabPage2
            // 
            this.xtraTabPage2.Name = "xtraTabPage2";
            this.xtraTabPage2.Size = new System.Drawing.Size(192, 349);
            this.xtraTabPage2.Text = "xtraTabPage2";
            // 
            // richTextBox1
            // 
            this.richTextBox1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.richTextBox1.Location = new System.Drawing.Point(0, 0);
            this.richTextBox1.Name = "richTextBox1";
            this.richTextBox1.Size = new System.Drawing.Size(199, 156);
            this.richTextBox1.TabIndex = 0;
            this.richTextBox1.Text = "";
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(13, 88);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(75, 23);
            this.button1.TabIndex = 1;
            this.button1.Text = "button1";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // listView1
            // 
            this.listView1.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader2});
            this.listView1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.listView1.Location = new System.Drawing.Point(0, 0);
            this.listView1.Name = "listView1";
            this.listView1.Size = new System.Drawing.Size(758, 537);
            this.listView1.TabIndex = 0;
            this.listView1.UseCompatibleStateImageBehavior = false;
            this.listView1.View = System.Windows.Forms.View.Details;
            // 
            // columnHeader2
            // 
            this.columnHeader2.Text = "Email";
            this.columnHeader2.Width = 1000;
            // 
            // button2
            // 
            this.button2.Location = new System.Drawing.Point(110, 69);
            this.button2.Name = "button2";
            this.button2.Size = new System.Drawing.Size(120, 42);
            this.button2.TabIndex = 1;
            this.button2.Text = "Spin";
            this.button2.UseVisualStyleBackColor = true;
            this.button2.Click += new System.EventHandler(this.button2_Click);
            // 
            // richTextBox3
            // 
            this.richTextBox3.Dock = System.Windows.Forms.DockStyle.Fill;
            this.richTextBox3.Location = new System.Drawing.Point(0, 0);
            this.richTextBox3.Name = "richTextBox3";
            this.richTextBox3.Size = new System.Drawing.Size(884, 431);
            this.richTextBox3.TabIndex = 0;
            this.richTextBox3.Text = "";
            // 
            // richTextBox2
            // 
            this.richTextBox2.Dock = System.Windows.Forms.DockStyle.Fill;
            this.richTextBox2.Location = new System.Drawing.Point(0, 0);
            this.richTextBox2.Name = "richTextBox2";
            this.richTextBox2.Size = new System.Drawing.Size(884, 100);
            this.richTextBox2.TabIndex = 0;
            this.richTextBox2.Text = "";
            // 
            // xtraTabControl1
            // 
            this.xtraTabControl1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.xtraTabControl1.Location = new System.Drawing.Point(0, 0);
            this.xtraTabControl1.LookAndFeel.SkinName = "iMaginary";
            this.xtraTabControl1.LookAndFeel.UseDefaultLookAndFeel = false;
            this.xtraTabControl1.Name = "xtraTabControl1";
            this.xtraTabControl1.SelectedTabPage = this.xtraTabPage1;
            this.xtraTabControl1.Size = new System.Drawing.Size(892, 565);
            this.xtraTabControl1.TabIndex = 1;
            this.xtraTabControl1.TabPages.AddRange(new DevExpress.XtraTab.XtraTabPage[] {
            this.xtraTabPage1,
            this.xtraTabPage3,
            this.xtraTabPage4});
            // 
            // xtraTabPage1
            // 
            this.xtraTabPage1.Controls.Add(this.splitContainerSitesVsBrowsers);
            this.xtraTabPage1.Name = "xtraTabPage1";
            this.xtraTabPage1.Size = new System.Drawing.Size(884, 537);
            this.xtraTabPage1.Text = "xtraTabPage1";
            // 
            // xtraTabPage3
            // 
            this.xtraTabPage3.Controls.Add(this.splitContainerControl1);
            this.xtraTabPage3.Name = "xtraTabPage3";
            this.xtraTabPage3.Size = new System.Drawing.Size(884, 537);
            this.xtraTabPage3.Text = "xtraTabPage3";
            // 
            // splitContainerControl1
            // 
            this.splitContainerControl1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainerControl1.Location = new System.Drawing.Point(0, 0);
            this.splitContainerControl1.Name = "splitContainerControl1";
            this.splitContainerControl1.Panel1.Controls.Add(this.button1);
            this.splitContainerControl1.Panel1.Text = "Panel1";
            this.splitContainerControl1.Panel2.Controls.Add(this.listView1);
            this.splitContainerControl1.Panel2.Text = "Panel2";
            this.splitContainerControl1.Size = new System.Drawing.Size(884, 537);
            this.splitContainerControl1.SplitterPosition = 120;
            this.splitContainerControl1.TabIndex = 0;
            this.splitContainerControl1.Text = "splitContainerControl1";
            // 
            // xtraTabPage4
            // 
            this.xtraTabPage4.Controls.Add(this.splitContainerControl2);
            this.xtraTabPage4.Name = "xtraTabPage4";
            this.xtraTabPage4.Size = new System.Drawing.Size(884, 537);
            this.xtraTabPage4.Text = "xtraTabPage4";
            // 
            // splitContainerControl2
            // 
            this.splitContainerControl2.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainerControl2.Horizontal = false;
            this.splitContainerControl2.Location = new System.Drawing.Point(0, 0);
            this.splitContainerControl2.Name = "splitContainerControl2";
            this.splitContainerControl2.Panel1.Controls.Add(this.button2);
            this.splitContainerControl2.Panel1.Controls.Add(this.richTextBox2);
            this.splitContainerControl2.Panel1.Text = "Panel1";
            this.splitContainerControl2.Panel2.Controls.Add(this.richTextBox3);
            this.splitContainerControl2.Panel2.Text = "Panel2";
            this.splitContainerControl2.Size = new System.Drawing.Size(884, 537);
            this.splitContainerControl2.TabIndex = 0;
            this.splitContainerControl2.Text = "splitContainerControl2";
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(892, 565);
            this.Controls.Add(this.xtraTabControl1);
            this.LookAndFeel.SkinName = "Caramel";
            this.LookAndFeel.UseDefaultLookAndFeel = false;
            this.Name = "Form1";
            this.Text = "Form1";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.Form1_FormClosing);
            this.Load += new System.EventHandler(this.Form1_Load);
            this.splitContainerSitesVsBrowsers.Panel1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsBrowsers)).EndInit();
            this.splitContainerSitesVsBrowsers.ResumeLayout(false);
            this.splitContainerSitesVsLog.Panel1.ResumeLayout(false);
            this.splitContainerSitesVsLog.Panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsLog)).EndInit();
            this.splitContainerSitesVsLog.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.tabControlSites)).EndInit();
            this.tabControlSites.ResumeLayout(false);
            this.tabPageSites.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.xtraTabControl1)).EndInit();
            this.xtraTabControl1.ResumeLayout(false);
            this.xtraTabPage1.ResumeLayout(false);
            this.xtraTabPage3.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerControl1)).EndInit();
            this.splitContainerControl1.ResumeLayout(false);
            this.xtraTabPage4.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerControl2)).EndInit();
            this.splitContainerControl2.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.ListView listViewSites;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.SplitContainer splitContainerSitesVsBrowsers;
        private System.Windows.Forms.RichTextBox richTextBox1;
        private System.Windows.Forms.SplitContainer splitContainerSitesVsLog;
        private System.Windows.Forms.Button button1;
        private System.Windows.Forms.ListView listView1;
        private System.Windows.Forms.ColumnHeader columnHeader2;
        private System.Windows.Forms.RichTextBox richTextBox3;
        private System.Windows.Forms.RichTextBox richTextBox2;
        private System.Windows.Forms.Button button2;
        private DevExpress.XtraTab.XtraTabControl tabControlSites;
        private DevExpress.XtraTab.XtraTabPage tabPageSites;
        private DevExpress.XtraTab.XtraTabPage xtraTabPage2;
        private DevExpress.XtraTab.XtraTabControl xtraTabControl1;
        private DevExpress.XtraTab.XtraTabPage xtraTabPage1;
        private DevExpress.XtraTab.XtraTabPage xtraTabPage3;
        private DevExpress.XtraEditors.SplitContainerControl splitContainerControl1;
        private DevExpress.XtraTab.XtraTabPage xtraTabPage4;
        private DevExpress.XtraEditors.SplitContainerControl splitContainerControl2;
    }
}

