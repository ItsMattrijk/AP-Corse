using System;
using System.Windows.Forms;
using Dapper;
using GestionConges.Models;

namespace GestionConges
{
    public partial class PraticienForm : Form
    {
        private Utilisateur _user;

        public PraticienForm(Utilisateur user)
        {
            InitializeComponent();
            _user = user;
            lblWelcome.Text = $"Bienvenue {_user.Prenom} ({_user.conges_restant} jours restants)";
        }

        private void btnDemander_Click(object sender, EventArgs e)
        {
            var jours = (dtFin.Value.Date - dtDebut.Value.Date).Days + 1;

            if (jours <= 0)
            {
                MessageBox.Show("Dates invalides");
                return;
            }

            if (jours > _user.conges_restant)
            {
                MessageBox.Show("Pas assez de congés restants !");
                return;
            }

            using (var conn = Db.GetConnection())
            {
                conn.Open();
                try
                {
                    conn.Execute(
                        "INSERT INTO conges (idUtilisateurFK, dateDebut, dateFin, statut) VALUES (@uid, @debut, @fin, @attente)",
                        new { uid = _user.Id, debut = dtDebut.Value.Date, fin = dtFin.Value.Date, attente="EN ATTENTE" }
                    );

                    MessageBox.Show("Demande envoyée !");
                }
                catch (Exception err)
                {
                    MessageBox.Show(err.Message);
                }
            }
        }

    }
}
