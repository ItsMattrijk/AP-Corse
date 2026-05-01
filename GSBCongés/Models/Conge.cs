using System;

namespace GestionConges.Models
{
    public class Conge
    {
        public int Id { get; set; }
        public int UtilisateurId { get; set; }
        public DateTime DateDebut { get; set; }
        public DateTime DateFin { get; set; }
        public string Statut { get; set; }
    }
}
