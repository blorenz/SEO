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
            this.tabControl1 = new System.Windows.Forms.TabControl();
            this.tabPage1 = new System.Windows.Forms.TabPage();
            this.splitContainerMasterAccountCreation = new System.Windows.Forms.SplitContainer();
            this.splitContainerSitesVsBrowsers = new System.Windows.Forms.SplitContainer();
            this.listViewSites = new System.Windows.Forms.ListView();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.richTextBox1 = new System.Windows.Forms.RichTextBox();
            this.tabPage2 = new System.Windows.Forms.TabPage();
            this.splitContainer3 = new System.Windows.Forms.SplitContainer();
            this.splitContainerSitesVsLog = new System.Windows.Forms.SplitContainer();
            this.tabControl1.SuspendLayout();
            this.tabPage1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerMasterAccountCreation)).BeginInit();
            this.splitContainerMasterAccountCreation.Panel2.SuspendLayout();
            this.splitContainerMasterAccountCreation.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsBrowsers)).BeginInit();
            this.splitContainerSitesVsBrowsers.Panel1.SuspendLayout();
            this.splitContainerSitesVsBrowsers.SuspendLayout();
            this.tabPage2.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainer3)).BeginInit();
            this.splitContainer3.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsLog)).BeginInit();
            this.splitContainerSitesVsLog.Panel1.SuspendLayout();
            this.splitContainerSitesVsLog.Panel2.SuspendLayout();
            this.splitContainerSitesVsLog.SuspendLayout();
            this.SuspendLayout();
            // 
            // tabControl1
            // 
            this.tabControl1.Controls.Add(this.tabPage1);
            this.tabControl1.Controls.Add(this.tabPage2);
            this.tabControl1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.tabControl1.Location = new System.Drawing.Point(0, 0);
            this.tabControl1.Name = "tabControl1";
            this.tabControl1.SelectedIndex = 0;
            this.tabControl1.Size = new System.Drawing.Size(892, 565);
            this.tabControl1.TabIndex = 0;
            // 
            // tabPage1
            // 
            this.tabPage1.Controls.Add(this.splitContainerMasterAccountCreation);
            this.tabPage1.Location = new System.Drawing.Point(4, 22);
            this.tabPage1.Name = "tabPage1";
            this.tabPage1.Padding = new System.Windows.Forms.Padding(3);
            this.tabPage1.Size = new System.Drawing.Size(884, 539);
            this.tabPage1.TabIndex = 0;
            this.tabPage1.Text = "Account Creation";
            this.tabPage1.UseVisualStyleBackColor = true;
            // 
            // splitContainerMasterAccountCreation
            // 
            this.splitContainerMasterAccountCreation.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainerMasterAccountCreation.Location = new System.Drawing.Point(3, 3);
            this.splitContainerMasterAccountCreation.Name = "splitContainerMasterAccountCreation";
            this.splitContainerMasterAccountCreation.Orientation = System.Windows.Forms.Orientation.Horizontal;
            this.splitContainerMasterAccountCreation.Panel1Collapsed = true;
            // 
            // splitContainerMasterAccountCreation.Panel2
            // 
            this.splitContainerMasterAccountCreation.Panel2.Controls.Add(this.splitContainerSitesVsBrowsers);
            this.splitContainerMasterAccountCreation.Size = new System.Drawing.Size(878, 533);
            this.splitContainerMasterAccountCreation.SplitterDistance = 371;
            this.splitContainerMasterAccountCreation.TabIndex = 3;
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
            this.splitContainerSitesVsBrowsers.Size = new System.Drawing.Size(878, 533);
            this.splitContainerSitesVsBrowsers.SplitterDistance = 198;
            this.splitContainerSitesVsBrowsers.TabIndex = 2;
            // 
            // listViewSites
            // 
            this.listViewSites.CheckBoxes = true;
            this.listViewSites.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1});
            this.listViewSites.Dock = System.Windows.Forms.DockStyle.Fill;
            this.listViewSites.Location = new System.Drawing.Point(0, 0);
            this.listViewSites.Name = "listViewSites";
            this.listViewSites.Size = new System.Drawing.Size(198, 375);
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
            // richTextBox1
            // 
            this.richTextBox1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.richTextBox1.Location = new System.Drawing.Point(0, 0);
            this.richTextBox1.Name = "richTextBox1";
            this.richTextBox1.Size = new System.Drawing.Size(198, 154);
            this.richTextBox1.TabIndex = 0;
            this.richTextBox1.Text = "";
            // 
            // tabPage2
            // 
            this.tabPage2.Controls.Add(this.splitContainer3);
            this.tabPage2.Location = new System.Drawing.Point(4, 22);
            this.tabPage2.Name = "tabPage2";
            this.tabPage2.Padding = new System.Windows.Forms.Padding(3);
            this.tabPage2.Size = new System.Drawing.Size(884, 539);
            this.tabPage2.TabIndex = 1;
            this.tabPage2.Text = "Email Verification";
            this.tabPage2.UseVisualStyleBackColor = true;
            // 
            // splitContainer3
            // 
            this.splitContainer3.Dock = System.Windows.Forms.DockStyle.Fill;
            this.splitContainer3.Location = new System.Drawing.Point(3, 3);
            this.splitContainer3.Name = "splitContainer3";
            this.splitContainer3.Size = new System.Drawing.Size(878, 533);
            this.splitContainer3.SplitterDistance = 292;
            this.splitContainer3.TabIndex = 0;
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
            this.splitContainerSitesVsLog.Panel1.Controls.Add(this.listViewSites);
            // 
            // splitContainerSitesVsLog.Panel2
            // 
            this.splitContainerSitesVsLog.Panel2.Controls.Add(this.richTextBox1);
            this.splitContainerSitesVsLog.Size = new System.Drawing.Size(198, 533);
            this.splitContainerSitesVsLog.SplitterDistance = 375;
            this.splitContainerSitesVsLog.TabIndex = 1;
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(892, 565);
            this.Controls.Add(this.tabControl1);
            this.Name = "Form1";
            this.Text = "Form1";
            this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.Form1_FormClosing);
            this.Load += new System.EventHandler(this.Form1_Load);
            this.tabControl1.ResumeLayout(false);
            this.tabPage1.ResumeLayout(false);
            this.splitContainerMasterAccountCreation.Panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerMasterAccountCreation)).EndInit();
            this.splitContainerMasterAccountCreation.ResumeLayout(false);
            this.splitContainerSitesVsBrowsers.Panel1.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsBrowsers)).EndInit();
            this.splitContainerSitesVsBrowsers.ResumeLayout(false);
            this.tabPage2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainer3)).EndInit();
            this.splitContainer3.ResumeLayout(false);
            this.splitContainerSitesVsLog.Panel1.ResumeLayout(false);
            this.splitContainerSitesVsLog.Panel2.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.splitContainerSitesVsLog)).EndInit();
            this.splitContainerSitesVsLog.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.TabControl tabControl1;
        private System.Windows.Forms.TabPage tabPage1;
        private System.Windows.Forms.TabPage tabPage2;
        private System.Windows.Forms.ListView listViewSites;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.SplitContainer splitContainerSitesVsBrowsers;
        private System.Windows.Forms.SplitContainer splitContainerMasterAccountCreation;
        private System.Windows.Forms.RichTextBox richTextBox1;
        private System.Windows.Forms.SplitContainer splitContainer3;
        private System.Windows.Forms.SplitContainer splitContainerSitesVsLog;
    }
}

