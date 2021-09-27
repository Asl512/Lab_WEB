using Npgsql;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace DB
{
    public partial class Form1 : Form
    {
        NpgsqlConnection connect = new NpgsqlConnection("server=localhost;user id=postgres;Database=My BD;Port=5432;Password=1122");
        Form2 form2 = new Form2();
        Form3 form3 = new Form3();
        Form6 form6 = new Form6();
        public Form1()
        {
            InitializeComponent(); 
        }

        private void Form1_Load(object sender, EventArgs e)
        {
           
        }

        private void label1_Click(object sender, EventArgs e)
        {

        }

        private void label3_Click(object sender, EventArgs e)
        {

        }

        private void button2_Click(object sender, EventArgs e)
        {
            form3.Show(); // отображаем Form2
            this.Hide();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            string loginUser = textBox1.Text;
            string passUser = textBox2.Text;

            DataTable usersTable = new DataTable();

            NpgsqlCommand cmd = connect.CreateCommand();

            NpgsqlDataAdapter adapter = new NpgsqlDataAdapter(cmd);

            adapter.SelectCommand = cmd;

            cmd.CommandText = String.Format("SELECT * FROM users WHERE login = '{0}' AND password = '{1}'", loginUser, passUser);

            connect.Open();

            cmd.ExecuteNonQuery();

            connect.Close();

            adapter.Fill(usersTable);

            if (usersTable.Rows.Count > 0)
            {
                if(loginUser == "admin")
                {
                    this.Hide();
                    form2.usersTable = usersTable;
                    form2.Show();
                }
                else
                {
                    this.Hide();
                    form6.usersTable = usersTable;
                    form6.Show();
                }
            }
            else
            {
                MessageBox.Show("Данные не правильны");
            }

        }
    }
}
