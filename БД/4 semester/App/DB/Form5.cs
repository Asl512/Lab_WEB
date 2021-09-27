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
    public partial class Form5 : Form
    {
        NpgsqlConnection connect = new NpgsqlConnection("server=localhost;user id=postgres;Database=My BD;Port=5432;Password=1122");

        public Form5()
        {
            InitializeComponent();
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

        private void button1_Click(object sender, EventArgs e)
        {
            NpgsqlCommand cmd = connect.CreateCommand();
            DataTable dt = new DataTable();
            cmd.CommandText = String.Format("SELECT name_student, surname_student FROM get_students_group('{0}')", comboBox1.Text);
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
            NpgsqlDataAdapter sql = new NpgsqlDataAdapter(cmd);
            sql.Fill(dt);
            CopyDataTableToListView(dt, Program.form2.listView1);
            this.Hide();
        }

        public void Combobox(ComboBox box, string textsql)
        {
            DataTable dt = new DataTable();
            NpgsqlCommand cmd = connect.CreateCommand();
            cmd.CommandText = textsql;
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
            NpgsqlDataAdapter sQLiteTableToListView = new NpgsqlDataAdapter(cmd);
            sQLiteTableToListView.Fill(dt);

            box.Items.Clear();
            string[] arrCities = new string[dt.Rows.Count];
            int b = 0;
            foreach (DataRow row in dt.Rows)
            {
                var list = row.ItemArray.Select(ob => ob.ToString()).ToArray();
                ListViewItem item = new ListViewItem(list);
                arrCities[b] = item.Text;
                b++;
            }

            box.Items.AddRange(arrCities);
            box.SelectedItem = box.Items[0];
        }

        private void Form5_Load(object sender, EventArgs e)
        {
            Combobox(comboBox1, "SELECT name FROM groups");
        }
    }
}
