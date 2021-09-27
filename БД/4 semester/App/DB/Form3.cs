using Npgsql;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace DB
{
    public partial class Form3 : Form
    {

        NpgsqlConnection connect = new NpgsqlConnection("server=localhost;user id=postgres;Database=My BD;Port=5432;Password=1122");
        public Form3()
        {
            InitializeComponent();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            Form1 form1 = new Form1();
            form1.Show(); // отображаем Form2
            this.Hide();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if ((textBox1.Text == "") || (textBox2.Text == "") || (textBox3.Text == ""))
            {
                MessageBox.Show("Одно из полей пустое");
            }
            else if (!Regex.Match(textBox1.Text, @"[а-яА-Я]").Success)
            {
                MessageBox.Show("Имя пишется на кириллице");
            }
            else if ((!Regex.Match(textBox2.Text, @"[a-zA-Z]").Success)|| (!Regex.Match(textBox3.Text, @"[a-zA-Z]|[0-9]|[-,._]").Success))
            {
                MessageBox.Show("Логин и пароль пишется латинскими символами");
            }
            else if (!Regex.Match(textBox2.Text, @"[0-9a-z_-]+@[0-9a-z_-]+\.[a-z]").Success)
            {
                MessageBox.Show("Логин пишется по типу xxx@xxx.xxx");
            }
            else
            {
                NpgsqlCommand cmd = connect.CreateCommand();

                cmd.CommandText = "SELECT * FROM users";

                connect.Open();

                cmd.ExecuteNonQuery();

                connect.Close();

                NpgsqlDataAdapter sQLiteTableToListView = new NpgsqlDataAdapter(cmd);

                string insert = String.Format("INSERT INTO users (name, login, password) VALUES ('{0}','{1}','{2}')", textBox1.Text, textBox2.Text, textBox3.Text);

                NpgsqlCommand cmd2 = new NpgsqlCommand(insert, connect);

                connect.Open();


                if (cmd2.ExecuteNonQuery() == 1)
                {
                    MessageBox.Show("Аккаунт был создан");
                }
                else
                {
                    MessageBox.Show("Аккаунт не был создан");
                }
                connect.Close();

                Form6 form6 = new Form6();
                form6.Show(); // отображаем Form2
                this.Hide(); // скрываем Form1 (this - текущая форма)
            }
        }

        private void label5_Click(object sender, EventArgs e)
        {

        }

        private void label7_Click(object sender, EventArgs e)
        {

        }
    }
}
