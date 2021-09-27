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
    public partial class Form8 : Form
    {
        NpgsqlConnection connect = new NpgsqlConnection("server=localhost;user id=postgres;Database=My BD;Port=5432;Password=1122");
        public Form8()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            if (dateTimePicker1.Value.Date <= dateTimePicker2.Value.Date)
            {
                NpgsqlCommand cmd = connect.CreateCommand();
                DataTable dt = new DataTable();
                cmd.CommandText = String.Format("SELECT name_exam, date FROM exam WHERE date BETWEEN '{0}' AND '{1}'", dateTimePicker1.Text, dateTimePicker2.Text);
                connect.Open();
                cmd.ExecuteNonQuery();
                connect.Close();
                NpgsqlDataAdapter sql = new NpgsqlDataAdapter(cmd);
                sql.Fill(dt);
                CopyDataTableToListView(dt, Program.form2.listView1);
                this.Hide();
            }
            else
            {
                MessageBox.Show("Первая дата не может быть больше второй");
            }
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
