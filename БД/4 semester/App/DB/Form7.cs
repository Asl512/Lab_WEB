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
    public partial class Form7 : Form
    {
        NpgsqlConnection connect = new NpgsqlConnection("server=localhost;user id=postgres;Database=My BD;Port=5432;Password=1122");
        public Form7()
        {
            Program.form7 = this;
            InitializeComponent();

            DataTable dt = new DataTable();
            NpgsqlCommand cmd = connect.CreateCommand();
            cmd.CommandText = "SELECT name,surname FROM students";
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
            NpgsqlDataAdapter sQLiteTableToListView = new NpgsqlDataAdapter(cmd);
            sQLiteTableToListView.Fill(dt);

            comboBox1.Items.Clear();
            string[] arrCities = new string[dt.Rows.Count];
            int b = 0;
            foreach (DataRow row in dt.Rows)
            {
                var list = row.ItemArray.Select(ob => ob.ToString()).ToArray();
                ListViewItem item = new ListViewItem(list);
                //MessageBox.Show(list[1].ToString());
                arrCities[b] = list[0].ToString() + " " + list[1].ToString();
                b++;
            }

            comboBox1.Items.AddRange(arrCities);
            comboBox1.SelectedItem = comboBox1.Items[0];
        }

        private void button1_Click(object sender, EventArgs e)
        {
            NpgsqlCommand cmd = connect.CreateCommand();
            DataTable dt = new DataTable();
            cmd.CommandText = String.Format("SELECT students.name, students.surname, exam.name_exam, exam.date FROM students_exam INNER JOIN exam ON students_exam.fk_id_exam = exam.id INNER JOIN students ON students_exam.fk_id_student = students.id WHERE students.name = '{0}' AND students.surname = '{1}'", comboBox1.Text.Split(' ')[0], comboBox1.Text.Split(' ')[1]);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
            NpgsqlDataAdapter sql = new NpgsqlDataAdapter(cmd);
            sql.Fill(dt);
            CopyDataTableToListView(dt, Program.form2.listView1);
            this.Hide();
        }

        public static void CopyDataTableToListView(DataTable data, ListView lv)
        {
            lv.BeginUpdate();
            if (lv.Columns.Count != data.Columns.Count)
            {
                lv.Columns.Clear();

                foreach (DataColumn column in data.Columns)
                {
                    lv.Columns.Add(column.ColumnName);
                }
            }
            lv.Items.Clear();

            foreach (DataRow row in data.Rows)
            {
                var list = row.ItemArray.Select(ob => ob.ToString()).ToArray();
                ListViewItem item = new ListViewItem(list);
                lv.Items.Add(item);
            }
            lv.AutoResizeColumns(ColumnHeaderAutoResizeStyle.ColumnContent);
            lv.AutoResizeColumns(ColumnHeaderAutoResizeStyle.HeaderSize);
            lv.EndUpdate();
        }
    }
}
