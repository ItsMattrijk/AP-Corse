using System;
using System.Linq;
using System.Windows.Forms;
using Dapper;

namespace GestionConges
{
    public partial class RhForm : Form
    {
        private Models.Utilisateur _user; // 🔹 On garde l'utilisateur connecté

        public RhForm(Models.Utilisateur user)
        {
            InitializeComponent();
            _user = user;
            LoadConges(); // Par défaut, affiche tous les congés
        }

        // 🔹 Chargement des congés avec filtre
        private void LoadConges(string statutFiltre = "Tous")
        {
            using (var conn = Db.GetConnection())
            {
                conn.Open();
                string sql = "SELECT c.id, c.idUtilisateurFK, u.nom, u.prenom, c.dateDebut, c.dateFin, c.statut " +
                             "FROM conges c JOIN utilisateurs u ON c.idUtilisateurFK = u.id";

                var data = statutFiltre != "Tous"
                    ? conn.Query(sql + " WHERE c.statut = @statut", new { statut = statutFiltre.ToLower() }).ToList()
                    : conn.Query(sql).ToList();

                dataGridView1.DataSource = data;
            }

            // 🔹 Renommer les colonnes
            if (dataGridView1.Columns["nom"] != null) dataGridView1.Columns["nom"].HeaderText = "Nom";
            if (dataGridView1.Columns["prenom"] != null) dataGridView1.Columns["prenom"].HeaderText = "Prénom";
            if (dataGridView1.Columns["dateDebut"] != null) dataGridView1.Columns["dateDebut"].HeaderText = "Début";
            if (dataGridView1.Columns["dateFin"] != null) dataGridView1.Columns["dateFin"].HeaderText = "Fin";
            if (dataGridView1.Columns["statut"] != null) dataGridView1.Columns["statut"].HeaderText = "Statut";

            // 🔹 Masquer les colonnes techniques
            if (dataGridView1.Columns["id"] != null) dataGridView1.Columns["id"].Visible = false;
            if (dataGridView1.Columns["idUtilisateurFK"] != null) dataGridView1.Columns["idUtilisateurFK"].Visible = false;
        }

        // 🔹 Filtres
        private void btnTous_Click(object sender, EventArgs e) => LoadConges("Tous");
        private void btnEnAttente_Click(object sender, EventArgs e) => LoadConges("en attente");
        private void btnAccepteFiltre_Click(object sender, EventArgs e) => LoadConges("accepte");
        private void btnRefuseFiltre_Click(object sender, EventArgs e) => LoadConges("refuse");

        // 🔹 Quand on sélectionne une ligne
        private void dataGridView1_SelectionChanged(object sender, EventArgs e)
        {
            if (dataGridView1.CurrentRow == null) return;

            string nom = dataGridView1.CurrentRow.Cells["nom"].Value.ToString();
            string prenom = dataGridView1.CurrentRow.Cells["prenom"].Value.ToString();
            DateTime debut = Convert.ToDateTime(dataGridView1.CurrentRow.Cells["dateDebut"].Value);
            DateTime fin = Convert.ToDateTime(dataGridView1.CurrentRow.Cells["dateFin"].Value);
            string statut = dataGridView1.CurrentRow.Cells["statut"].Value.ToString();

            int jours = (fin.Date - debut.Date).Days + 1;

            lblDemande.Text = $"Demande de congés de {prenom} {nom}";
            lblDuree.Text = $"Durée : {jours} jours";
            lblStatut.Text = $"Statut : {statut}";
        }

        // 🔹 Accepter un congé
        private void btnAccepter_Click(object sender, EventArgs e)
        {
            if (dataGridView1.CurrentRow == null) return;
            int congeId = Convert.ToInt32(dataGridView1.CurrentRow.Cells["id"].Value);
            int utilisateurId = Convert.ToInt32(dataGridView1.CurrentRow.Cells["idUtilisateurFK"].Value);
            DateTime debut = Convert.ToDateTime(dataGridView1.CurrentRow.Cells["dateDebut"].Value);
            DateTime fin = Convert.ToDateTime(dataGridView1.CurrentRow.Cells["dateFin"].Value);
            int jours = (fin.Date - debut.Date).Days + 1;

            using (var conn = Db.GetConnection())
            {
                conn.Open();
                using (var tr = conn.BeginTransaction())
                {
                    conn.Execute("UPDATE conges SET statut='accepte' WHERE id=@id", new { id = congeId }, tr);
                    // Si tu veux décompter les jours :
                    // conn.Execute("UPDATE utilisateurs SET conges_restant = conges_restant - @jours WHERE id=@uid",
                    //     new { jours, uid = utilisateurId }, tr);
                    tr.Commit();
                }
            }
            LoadConges();
        }

        // 🔹 Refuser un congé
        private void btnRefuser_Click(object sender, EventArgs e)
        {
            if (dataGridView1.CurrentRow == null) return;
            int congeId = Convert.ToInt32(dataGridView1.CurrentRow.Cells["id"].Value);

            using (var conn = Db.GetConnection())
            {
                conn.Open();
                conn.Execute("UPDATE conges SET statut='refuse' WHERE id=@id", new { id = congeId });
            }
            LoadConges();
        }

        // 🔹 Nouveau bouton : Rediriger vers la page PraticienForm
        private void btnDemanderConge_Click(object sender, EventArgs e)
        {
            // Ouvre la fenêtre de demande de congés avec le même utilisateur
            var praticienForm = new PraticienForm(_user);
            praticienForm.Show();
        }
    }
}
