namespace GestionConges
{
    partial class RhForm
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.DataGridView dataGridView1;
        private System.Windows.Forms.Button btnAccepter;
        private System.Windows.Forms.Button btnRefuser;
        private System.Windows.Forms.Label lblDemande;
        private System.Windows.Forms.Label lblDuree;
        private System.Windows.Forms.Label lblStatut;

        // Boutons de filtre
        private System.Windows.Forms.Button btnTous;
        private System.Windows.Forms.Button btnEnAttente;
        private System.Windows.Forms.Button btnAccepteFiltre;
        private System.Windows.Forms.Button btnRefuseFiltre;
        private System.Windows.Forms.Button btnDemanderConge;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null)) components.Dispose();
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(RhForm));
            this.dataGridView1 = new System.Windows.Forms.DataGridView();
            this.btnAccepter = new System.Windows.Forms.Button();
            this.btnRefuser = new System.Windows.Forms.Button();
            this.lblDemande = new System.Windows.Forms.Label();
            this.lblDuree = new System.Windows.Forms.Label();
            this.lblStatut = new System.Windows.Forms.Label();
            this.btnTous = new System.Windows.Forms.Button();
            this.btnEnAttente = new System.Windows.Forms.Button();
            this.btnAccepteFiltre = new System.Windows.Forms.Button();
            this.btnRefuseFiltre = new System.Windows.Forms.Button();
            this.pictureBox1 = new System.Windows.Forms.PictureBox();
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).BeginInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).BeginInit();
            this.SuspendLayout();
            // 
            // dataGridView1
            // 
            this.dataGridView1.BackgroundColor = System.Drawing.Color.PowderBlue;
            this.dataGridView1.Location = new System.Drawing.Point(12, 50);
            this.dataGridView1.MultiSelect = false;
            this.dataGridView1.Name = "dataGridView1";
            this.dataGridView1.ReadOnly = true;
            this.dataGridView1.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.dataGridView1.Size = new System.Drawing.Size(500, 310);
            this.dataGridView1.TabIndex = 1;
            this.dataGridView1.SelectionChanged += new System.EventHandler(this.dataGridView1_SelectionChanged);
            // 
            // btnAccepter
            // 
            this.btnAccepter.BackColor = System.Drawing.Color.MintCream;
            this.btnAccepter.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnAccepter.ForeColor = System.Drawing.Color.LimeGreen;
            this.btnAccepter.Location = new System.Drawing.Point(12, 370);
            this.btnAccepter.Name = "btnAccepter";
            this.btnAccepter.Size = new System.Drawing.Size(120, 30);
            this.btnAccepter.TabIndex = 2;
            this.btnAccepter.Text = "Accepter";
            this.btnAccepter.UseVisualStyleBackColor = false;
            this.btnAccepter.Click += new System.EventHandler(this.btnAccepter_Click);
            // 
            // btnRefuser
            // 
            this.btnRefuser.BackColor = System.Drawing.Color.MintCream;
            this.btnRefuser.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnRefuser.ForeColor = System.Drawing.Color.Red;
            this.btnRefuser.Location = new System.Drawing.Point(140, 370);
            this.btnRefuser.Name = "btnRefuser";
            this.btnRefuser.Size = new System.Drawing.Size(120, 30);
            this.btnRefuser.TabIndex = 3;
            this.btnRefuser.Text = "Refuser";
            this.btnRefuser.UseVisualStyleBackColor = false;
            this.btnRefuser.Click += new System.EventHandler(this.btnRefuser_Click);
            // 
            // lblDemande
            // 
            this.lblDemande.AutoSize = true;
            this.lblDemande.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.lblDemande.FlatStyle = System.Windows.Forms.FlatStyle.Popup;
            this.lblDemande.Font = new System.Drawing.Font("Segoe UI", 11.25F, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point);
            this.lblDemande.ForeColor = System.Drawing.Color.DodgerBlue;
            this.lblDemande.Location = new System.Drawing.Point(528, 53);
            this.lblDemande.Name = "lblDemande";
            this.lblDemande.Padding = new System.Windows.Forms.Padding(0, 2, 20, 7);
            this.lblDemande.Size = new System.Drawing.Size(180, 31);
            this.lblDemande.TabIndex = 4;
            this.lblDemande.Text = "Demande de congés :";
            // 
            // lblDuree
            // 
            this.lblDuree.AutoSize = true;
            this.lblDuree.Location = new System.Drawing.Point(530, 90);
            this.lblDuree.Name = "lblDuree";
            this.lblDuree.Size = new System.Drawing.Size(47, 15);
            this.lblDuree.TabIndex = 5;
            this.lblDuree.Text = "Durée : ";
            // 
            // lblStatut
            // 
            this.lblStatut.AutoSize = true;
            this.lblStatut.Location = new System.Drawing.Point(530, 120);
            this.lblStatut.Name = "lblStatut";
            this.lblStatut.Size = new System.Drawing.Size(47, 15);
            this.lblStatut.TabIndex = 6;
            this.lblStatut.Text = "Statut : ";
            // 
            // btnTous
            // 
            this.btnTous.BackColor = System.Drawing.Color.MintCream;
            this.btnTous.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnTous.ForeColor = System.Drawing.Color.SteelBlue;
            this.btnTous.Location = new System.Drawing.Point(12, 12);
            this.btnTous.Name = "btnTous";
            this.btnTous.Size = new System.Drawing.Size(100, 30);
            this.btnTous.TabIndex = 0;
            this.btnTous.Text = "Tous";
            this.btnTous.UseVisualStyleBackColor = false;
            this.btnTous.Click += new System.EventHandler(this.btnTous_Click);
            // 
            // btnEnAttente
            // 
            this.btnEnAttente.BackColor = System.Drawing.Color.MintCream;
            this.btnEnAttente.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnEnAttente.ForeColor = System.Drawing.Color.SteelBlue;
            this.btnEnAttente.Location = new System.Drawing.Point(117, 12);
            this.btnEnAttente.Name = "btnEnAttente";
            this.btnEnAttente.Size = new System.Drawing.Size(100, 30);
            this.btnEnAttente.TabIndex = 1;
            this.btnEnAttente.Text = "En attente";
            this.btnEnAttente.UseVisualStyleBackColor = false;
            this.btnEnAttente.Click += new System.EventHandler(this.btnEnAttente_Click);
            // 
            // btnAccepteFiltre
            // 
            this.btnAccepteFiltre.BackColor = System.Drawing.Color.MintCream;
            this.btnAccepteFiltre.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnAccepteFiltre.ForeColor = System.Drawing.Color.LimeGreen;
            this.btnAccepteFiltre.Location = new System.Drawing.Point(222, 12);
            this.btnAccepteFiltre.Name = "btnAccepteFiltre";
            this.btnAccepteFiltre.Size = new System.Drawing.Size(100, 30);
            this.btnAccepteFiltre.TabIndex = 2;
            this.btnAccepteFiltre.Text = "Accepté";
            this.btnAccepteFiltre.UseVisualStyleBackColor = false;
            this.btnAccepteFiltre.Click += new System.EventHandler(this.btnAccepteFiltre_Click);
            // 
            // btnRefuseFiltre
            // 
            this.btnRefuseFiltre.BackColor = System.Drawing.Color.MintCream;
            this.btnRefuseFiltre.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnRefuseFiltre.ForeColor = System.Drawing.Color.Red;
            this.btnRefuseFiltre.Location = new System.Drawing.Point(327, 12);
            this.btnRefuseFiltre.Name = "btnRefuseFiltre";
            this.btnRefuseFiltre.Size = new System.Drawing.Size(100, 30);
            this.btnRefuseFiltre.TabIndex = 3;
            this.btnRefuseFiltre.Text = "Refusé";
            this.btnRefuseFiltre.UseVisualStyleBackColor = false;
            this.btnRefuseFiltre.Click += new System.EventHandler(this.btnRefuseFiltre_Click);
            // 
            // btnDemanderConge
            // 
            this.btnDemanderConge = new System.Windows.Forms.Button();
            this.btnDemanderConge.BackColor = System.Drawing.Color.MintCream;
            this.btnDemanderConge.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.btnDemanderConge.ForeColor = System.Drawing.Color.MediumVioletRed;
            this.btnDemanderConge.Location = new System.Drawing.Point(432, 12);
            this.btnDemanderConge.Name = "btnDemanderConge";
            this.btnDemanderConge.Size = new System.Drawing.Size(150, 30);
            this.btnDemanderConge.TabIndex = 4;
            this.btnDemanderConge.Text = "Demander des congés";
            this.btnDemanderConge.UseVisualStyleBackColor = false;
            this.btnDemanderConge.Click += new System.EventHandler(this.btnDemanderConge_Click);

            // 
            // pictureBox1
            // 
            this.pictureBox1.BackgroundImage = ((System.Drawing.Image)(resources.GetObject("pictureBox1.BackgroundImage")));
            this.pictureBox1.Location = new System.Drawing.Point(581, 188);
            this.pictureBox1.Name = "pictureBox1";
            this.pictureBox1.Size = new System.Drawing.Size(45, 29);
            this.pictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
            this.pictureBox1.TabIndex = 7;
            this.pictureBox1.TabStop = false;
            // 
            // RhForm
            // 
            this.BackColor = System.Drawing.Color.PaleTurquoise;
            this.ClientSize = new System.Drawing.Size(800, 420);
            this.Controls.Add(this.pictureBox1);
            this.Controls.Add(this.btnTous);
            this.Controls.Add(this.btnEnAttente);
            this.Controls.Add(this.btnAccepteFiltre);
            this.Controls.Add(this.btnRefuseFiltre);
            this.Controls.Add(this.dataGridView1);
            this.Controls.Add(this.btnAccepter);
            this.Controls.Add(this.btnRefuser);
            this.Controls.Add(this.btnDemanderConge);
            this.Controls.Add(this.lblDemande);
            this.Controls.Add(this.lblDuree);
            this.Controls.Add(this.lblStatut);
            this.Name = "RhForm";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Espace RH - Gestion Congés";
            ((System.ComponentModel.ISupportInitialize)(this.dataGridView1)).EndInit();
            ((System.ComponentModel.ISupportInitialize)(this.pictureBox1)).EndInit();
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        private PictureBox pictureBox1;
    }
}
