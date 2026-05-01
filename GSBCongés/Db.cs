using MySql.Data.MySqlClient;

namespace GestionConges
{
    public static class Db
    {
        private static string connectionString = "Server=localhost;Database=gsb_opti;Uid=root;Pwd=;";
        //private static string connectionString = "Server=172.23.80.2;Database=gsbeh;Uid=wassil;Pwd=1234;"; // on avais pas autre chose comme mdp

        public static MySqlConnection GetConnection()
        {
            return new MySqlConnection(connectionString);
        }
    }
}
