using System;
using System.Windows.Forms;
using Dapper;
using GestionConges.Models;
using Org.BouncyCastle.Asn1.X509;

namespace GestionConges
{
    public partial class LoginForm : Form
    {
        public LoginForm()
        {
            InitializeComponent();
        }

        private void btnLogin_Click(object sender, EventArgs e)
        {
            using (var conn = Db.GetConnection())
            {
                conn.Open();
                var user = conn.QueryFirstOrDefault<Utilisateur>(
                    "SELECT * FROM utilisateurs WHERE email=@Email AND pwd=@Mdp",
                    new { Email = txtEmail.Text.Trim(), Mdp = txtPassword.Text.Trim() });

                if (user != null)
                {
                    if (user.Role == "praticien")
                    {
                        var f = new PraticienForm(user);
                        f.Show();
                    }
                    else
                    {
                        var f = new RhForm(user);
                        f.Show();
                    }
                    this.Hide();
                }
                else
                {
                    MessageBox.Show("Identifiants invalides !", "Erreur", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                }
            }
        }
    }
}
