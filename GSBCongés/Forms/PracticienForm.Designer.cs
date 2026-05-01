namespace GestionConges
{
    partial class PraticienForm
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Label lblWelcome;
        private System.Windows.Forms.DateTimePicker dtDebut;
        private System.Windows.Forms.DateTimePicker dtFin;
        private System.Windows.Forms.Button btnDemander;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null)) components.Dispose();
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.lblWelcome = new System.Windows.Forms.Label();
            this.dtDebut = new System.Windows.Forms.DateTimePicker();
            this.dtFin = new System.Windows.Forms.DateTimePicker();
            this.btnDemander = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // lblWelcome
            this.lblWelcome.AutoSize = true;
            this.lblWelcome.Location = new System.Drawing.Point(12, 9);
            this.lblWelcome.Name = "lblWelcome";
            this.lblWelcome.Size = new System.Drawing.Size(75, 15);
            // dtDebut
            this.dtDebut.Location = new System.Drawing.Point(12, 40);
            this.dtDebut.Name = "dtDebut";
            this.dtDebut.Size = new System.Drawing.Size(250, 23);
            // dtFin
            this.dtFin.Location = new System.Drawing.Point(12, 80);
            this.dtFin.Name = "dtFin";
            this.dtFin.Size = new System.Drawing.Size(250, 23);
            // btnDemander
            this.btnDemander.Location = new System.Drawing.Point(12, 120);
            this.btnDemander.Name = "btnDemander";
            this.btnDemander.Size = new System.Drawing.Size(120, 30);
            this.btnDemander.Text = "Demander";
            this.btnDemander.UseVisualStyleBackColor = true;
            this.btnDemander.Click += new System.EventHandler(this.btnDemander_Click);
            // PraticienForm
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(400, 180);
            this.Controls.Add(this.lblWelcome);
            this.Controls.Add(this.dtDebut);
            this.Controls.Add(this.dtFin);
            this.Controls.Add(this.btnDemander);
            this.Name = "PraticienForm";
            this.Text = "Espace Praticien";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.ResumeLayout(false);
            this.PerformLayout();
        }
    }
}
