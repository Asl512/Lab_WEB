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
    public partial class Form2 : Form
    {
        NpgsqlConnection connect = new NpgsqlConnection("server=localhost;user id=postgres;Database=My BD;Port=5432;Password=1122");
        public DataTable usersTable = null;
        static string table = "";
        public Form2()
        {
            Program.form2 = this;
            InitializeComponent();
        }

        private void Form2_Load(object sender, EventArgs e)
        {
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
            table = "groups";
            comboBox1.Visible = false;
            comboBox3.Visible = false;
            textBox3.Visible = false;
            textBox5.Visible = false;
            label3.Visible = false;
            textBox6.Visible = false;
            label2.Visible = false;
            label7.Visible = false;
            button14.Visible = false;
            button15.Visible = false;
            button16.Visible = false;
            label8.Visible = false;
            label17.Visible = false;
            label9.Visible = false;
            textBox7.Visible = false;
            label21.Visible = false;
            label22.Visible = false;
            label23.Visible = false;
            label24.Visible = false;
            label25.Visible = false;
            label26.Visible = false;
            comboBox6.Visible = false;
            comboBox7.Visible = false;
            comboBox8.Visible = false;
            comboBox9.Visible = false;
            comboBox10.Visible = false;
            comboBox11.Visible = false;
            label19.Visible = false;
            label20.Visible = false;
            dateTimePicker1.Visible = false;
            dateTimePicker2.Visible = false;
            label18.Visible = false;
            label4.Visible = false;
            button12.Visible = false;
            button13.Visible = false;
            View_true();
            button8.Visible = true;
            button7.Visible = true;
            textBox2.Visible = true;
            label5.Visible = true;
            label10.Visible = true;
            textBox4.Visible = true;
            button4.Visible = true;
            Combobox(comboBox2, "SELECT id FROM groups");
            Combobox(comboBox4, "SELECT id FROM groups");
            Qery("select * from groups");
        }

        private void View_true()
        {
            textBox1.Visible = true;
            label15.Visible = true;
            label16.Visible = true;
            listView6.Visible = true;
            comboBox4.Visible = true;
            button6.Visible = true;
            button3.Visible = true;
            button5.Visible = true;
            label11.Visible = true;
            listView2.Visible = true;
            label12.Visible = true;
            listView3.Visible = true;
            label14.Visible = true;
            listView5.Visible = true;
            comboBox2.Visible = true;
            label1.Visible = true;
            label6.Visible = true;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            table = "students";
            button8.Visible = false;
            label5.Visible = false;
            label10.Visible = false;
            button4.Visible = false;
            label18.Visible = false;
            textBox7.Visible = false;
            label19.Visible = false;
            label20.Visible = false;
            dateTimePicker1.Visible = false;
            dateTimePicker2.Visible = false;
            label17.Visible = false;
            textBox6.Visible = false;
            button14.Visible = false;
            button15.Visible = false;
            button16.Visible = false;
            button7.Visible = false;
            label21.Visible = false;
            label22.Visible = false;
            label23.Visible = false;
            label24.Visible = false;
            label25.Visible = false;
            label26.Visible = false;
            comboBox6.Visible = false;
            comboBox7.Visible = false;
            comboBox8.Visible = false;
            comboBox9.Visible = false;
            comboBox10.Visible = false;
            comboBox11.Visible = false;
            View_true();
            textBox3.Visible = true;
            button12.Visible = true;
            button13.Visible = true;
            textBox5.Visible = true;
            comboBox1.Visible = true;
            comboBox3.Visible = true;
            label2.Visible = true;
            textBox2.Visible = true;
            textBox4.Visible = true;
            label7.Visible = true;
            label8.Visible = true;
            label9.Visible = true;
            label3.Visible = true;
            label4.Visible = true;
            Combobox(comboBox1, "SELECT name FROM groups");
            Combobox(comboBox2, "SELECT id FROM students");
            Combobox(comboBox4, "SELECT id FROM students");
            Combobox(comboBox3, "SELECT name FROM groups");
            Combobox(comboBox5, "SELECT id FROM groups");
            Qery("select * from students");
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

        private void label1_Click(object sender, EventArgs e)
        {

        }

        private void button3_Click(object sender, EventArgs e)
        {
            if (table == "groups")
            {
                if ((textBox1.Text == "") || (textBox2.Text == ""))
                {
                    MessageBox.Show("Одно из полей пустое");
                }
                else if (!Regex.Match(textBox2.Text, @"[а-яА-Я]").Success)
                {
                    MessageBox.Show("Название группы пишится на кириллице");
                }
                else
                {
                    Operation("SELECT * FROM groups", String.Format("INSERT INTO groups (id, name) VALUES ('{0}','{1}')", textBox1.Text, textBox2.Text), "Группа была добавлена", "ОШИБКА Группа не была добавлена");
                    Qery("select * from groups");
                }
            }
            else if (table == "students")
            {
                if ((textBox1.Text == "") || (textBox2.Text == "") || (textBox3.Text == ""))
                {
                    MessageBox.Show("Одно из полей пустое");
                }
                else if ((!Regex.Match(textBox2.Text, @"[а-яА-Я]").Success) || (!Regex.Match(textBox3.Text, @"[а-яА-Я]").Success))
                {
                    MessageBox.Show("Имя и Фамилия пишется на кириллице");
                }
                else if (!Regex.Match(textBox1.Text, @"[0-9]").Success)
                {
                    MessageBox.Show("Иденфикатор должен состоять из цифр");
                }
                else
                {
                    int id = comboBox1.SelectedIndex;
                    Operation("SELECT * FROM students", String.Format("INSERT INTO students VALUES ('{0}','{1}','{2}','{3}')", textBox1.Text, textBox2.Text, textBox3.Text, comboBox5.Items[id].ToString()), "Студент был добавлен", " ОШИБКА Студент небыл добавлен");
                    Qery("select * from students");
                }
            }
            else if (table == "exam")
            {
                if ((textBox1.Text == "") || (textBox2.Text == "") || (textBox6.Text == ""))
                {
                    MessageBox.Show("Одно из полей пустое");
                }
                else if (!Regex.Match(textBox6.Text, @"[0-9]").Success)
                {
                    MessageBox.Show("Номер аудитории состоит из цифр");
                }
                else if (!Regex.Match(textBox1.Text, @"[0-9]").Success)
                {
                    MessageBox.Show("Иденфикатор должен состоять из цифр");
                }
                else
                {
                    Operation("SELECT * FROM exam", String.Format("INSERT INTO exam VALUES ('{0}','{1}','{2}','{3}')", textBox1.Text, textBox2.Text, dateTimePicker1.Text, textBox6.Text), "Экзамен был добавлен", " ОШИБКА Экзамен не был добавлен");
                    Qery("select * from exam");
                }
            }
            else if (table == "appraisal")
            {
                if ((textBox1.Text == ""))
                {
                    MessageBox.Show("Поле ID не должно быть пустое");
                }
                else if (!Regex.Match(textBox1.Text, @"[0-9]").Success)
                {
                    MessageBox.Show("Иденфикатор должен состоять из цифр");
                }
                else
                {
                    int id_st = comboBox11.SelectedIndex;
                    int id_ex = comboBox10.SelectedIndex;
                    Operation("SELECT * FROM students_exam", String.Format("INSERT INTO students_exam VALUES ('{0}','{1}','{2}','{3}')", textBox1.Text, comboBox12.Items[id_st].ToString(), comboBox13.Items[id_ex].ToString(), comboBox9.Text), "Оценка была добавлена", " ОШИБКА Оценка не была добавлена");
                    Qery("SELECT students_exam.id_rec, students.name,students.surname, exam.name_exam, students_exam.appraisal FROM students INNER JOIN students_exam ON students.id = students_exam.fk_id_student INNER JOIN exam ON students_exam.fk_id_exam = exam.id");

                }
            }
        }

        public void Operation(string where, string sqltext, string message, string messageerr)
        {
            NpgsqlCommand cmd = connect.CreateCommand();
            cmd.CommandText = where;
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
            NpgsqlDataAdapter sQLiteTableToListView = new NpgsqlDataAdapter(cmd);
            string insert = sqltext;
            NpgsqlCommand cmd2 = new NpgsqlCommand(insert, connect);
            connect.Open();
            if (cmd2.ExecuteNonQuery() == 1)
            {
                MessageBox.Show(message);
            }
            else
            {
                MessageBox.Show(messageerr);
            }
            connect.Close();
        }
        public void Qery(string textsql)
        {
            NpgsqlCommand cmd = connect.CreateCommand();
            DataTable dt = new DataTable();
            cmd.CommandText = textsql;
            connect.Open();
            cmd.ExecuteNonQuery();
            connect.Close();
            NpgsqlDataAdapter sql = new NpgsqlDataAdapter(cmd);
            sql.Fill(dt);
            CopyDataTableToListView(dt, listView1);
        }

        private void button4_Click(object sender, EventArgs e)
        {
            Qery("SELECT groups.name, count(students.name) as count FROM groups, students WHERE groups.id = students.fk_id_group GROUP BY groups.name");
        }

        private void button13_Click(object sender, EventArgs e)
        {
            Qery("SELECT students.name, students.surname, SUM(students_exam.appraisal)/COUNT(students_exam.appraisal) AS average_rating FROM students, students_exam WHERE students.id = students_exam.fk_id_student GROUP BY students.name, students.surname");
        }

        private void button12_Click(object sender, EventArgs e)
        {
            Form4 f = new Form4();
            f.ShowDialog();
        }

        private void button7_Click(object sender, EventArgs e)
        {
            Qery("SELECT groups.name, SUM(students_exam.appraisal)/COUNT(students_exam.appraisal) FROM students, students_exam, groups WHERE students.id = students_exam.fk_id_student AND students.fk_id_group = groups.id GROUP BY groups.name");
        }

        private void button11_Click(object sender, EventArgs e)
        {
            Qery("SELECT * FROM view_students_exam");
        }

        private void button8_Click(object sender, EventArgs e)
        {
            Form5 f = new Form5();
            f.ShowDialog();
        }

        private void button5_Click(object sender, EventArgs e)
        {
            if (table == "groups")
            {
                if (textBox4.Text == "")
                {
                    MessageBox.Show("Название группы пустое");
                }
                else if (!Regex.Match(textBox4.Text, @"[а-яА-Я]").Success)
                {
                    MessageBox.Show("Название группы пишится на кириллице");
                }
                else
                {
                    Operation("SELECT * FROM groups", String.Format("UPDATE public.groups SET name = '{0}' WHERE id = '{1}'; ", textBox4.Text, comboBox2.Text), "Вы изменили руппу", "ОШИБКА вы не изменили группу");
                    Qery("select * from groups");
                }
            }
            else if (table == "students")
            {
                if ((textBox4.Text == "") || (textBox5.Text == ""))
                {
                    MessageBox.Show("Одно из полей пустое");
                }
                else if ((!Regex.Match(textBox4.Text, @"[а-яА-Я]").Success) || (!Regex.Match(textBox5.Text, @"[а-яА-Я]").Success))
                {
                    MessageBox.Show("Имя и Фамилия пишется на кириллице");
                }
                else
                {
                    int id = comboBox3.SelectedIndex;
                    Operation("SELECT * FROM students", String.Format("UPDATE public.students SET name='{0}', surname='{1}', fk_id_group='{2}' WHERE id = '{3}'; ", textBox4.Text, textBox5.Text, comboBox5.Items[id].ToString(), comboBox2.Text), "Студент был изменен", " ОШИБКА Студент не был изменен");
                    Qery("select * from students");
                }
            }
            else if (table == "exam")
            {
                if ((textBox4.Text == "") || (textBox7.Text == ""))
                {
                    MessageBox.Show("Одно из полей пустое");
                }
                else if (!Regex.Match(textBox7.Text, @"[0-9]").Success)
                {
                    MessageBox.Show("Номер аудитории состоит из цифр");
                }
                else
                {
                    Operation("SELECT * FROM exam", String.Format("UPDATE public.exam SET name_exam='{0}', date='{1}', numb_audience='{2}' WHERE id = '{3}'; ", textBox4.Text, dateTimePicker2.Text, textBox7.Text, comboBox2.Text), "Экзамен был изменен", " ОШИБКА Экзамен не был изменен");
                    Qery("select * from exam");
                }
            }
            else if (table == "appraisal")
            {
                int id_st = comboBox6.SelectedIndex;
                int id_ex = comboBox8.SelectedIndex;
                Operation("SELECT * FROM students_exam", String.Format("UPDATE public.students_exam SET fk_id_student ='{0}', fk_id_exam='{1}', appraisal='{2}' WHERE id_rec = '{3}'; ", comboBox12.Items[id_st].ToString(), comboBox13.Items[id_ex].ToString(), comboBox7.Text, comboBox2.Text), "Оценка была изменена", " ОШИБКА Оценка не была изменена");
                Qery("SELECT students_exam.id_rec, students.name,students.surname, exam.name_exam, students_exam.appraisal FROM students INNER JOIN students_exam ON students.id = students_exam.fk_id_student INNER JOIN exam ON students_exam.fk_id_exam = exam.id");

            }
        }

        private void button6_Click(object sender, EventArgs e)
        {
            if (table == "groups")
            {
                Operation("SELECT * FROM groups", String.Format("DELETE FROM public.groups WHERE id = '{0}'; ", comboBox4.Text), "Группа была удалена", " ОШИБКА Группа не была удалена");
                Qery("select * from groups");
            }
            else if (table == "students")
            {
                Operation("SELECT * FROM students", String.Format("DELETE FROM public.students WHERE id = '{0}'; ", comboBox4.Text), "Студент был удален", " ОШИБКА Студент не был удален");
                Qery("select * from students");
            }
            else if (table == "exam")
            {
                Operation("SELECT * FROM exam", String.Format("DELETE FROM public.exam WHERE id = '{0}'; ", comboBox4.Text), "Экзамен был удален", " ОШИБКА Экзамен не был удален");
                Qery("select * from exam");
            }
            else if (table == "appraisal")
            {
                Operation("SELECT * FROM students_exam", String.Format("DELETE FROM public.students_exam WHERE id_rec = '{0}'; ", comboBox4.Text), "Оценка была удалена", " ОШИБКА Оценка не была удалена");
                Qery("SELECT students_exam.id_rec, students.name,students.surname, exam.name_exam, students_exam.appraisal FROM students INNER JOIN students_exam ON students.id = students_exam.fk_id_student INNER JOIN exam ON students_exam.fk_id_exam = exam.id");

            }
        }

        private void comboBox3_SelectedIndexChanged(object sender, EventArgs e)
        {
        }

        private void button9_Click(object sender, EventArgs e)
        {
            Form1 form1 = new Form1();
            this.Hide();
            form1.Show();
        }

        private void button10_Click(object sender, EventArgs e)
        {
            table = "exam";
            button8.Visible = false;
            button4.Visible = false;
            button7.Visible = false;
            comboBox1.Visible = false;
            comboBox3.Visible = false;
            textBox3.Visible = false;
            textBox5.Visible = false;
            label3.Visible = false;
            label2.Visible = false;
            label7.Visible = false;
            label8.Visible = false;
            label9.Visible = false;
            label4.Visible = false;
            button12.Visible = false;
            button13.Visible = false;
            label21.Visible = false;
            label22.Visible = false;
            label23.Visible = false;
            label24.Visible = false;
            label25.Visible = false;
            label26.Visible = false;
            comboBox6.Visible = false;
            comboBox7.Visible = false;
            comboBox8.Visible = false;
            comboBox9.Visible = false;
            comboBox10.Visible = false;
            comboBox11.Visible = false;
            View_true();
            label17.Visible = true;
            label18.Visible = true;
            button14.Visible = true;
            button15.Visible = true;
            button16.Visible = true;
            textBox7.Visible = true;
            textBox2.Visible = true;
            label19.Visible = true;
            label20.Visible = true;
            textBox4.Visible = true;
            dateTimePicker1.Visible = true;
            dateTimePicker2.Visible = true;
            label5.Visible = true;
            label10.Visible = true;
            textBox6.Visible = true;
            Combobox(comboBox2, "SELECT id FROM exam");
            Combobox(comboBox4, "SELECT id FROM exam");
            Qery("select * from exam");
        }

        private void button14_Click(object sender, EventArgs e)
        {
            Form7 form7 = new Form7();
            form7.ShowDialog();
        }

        private void button15_Click(object sender, EventArgs e)
        {
            Form8 form8 = new Form8();
            form8.ShowDialog();
        }

        private void button16_Click(object sender, EventArgs e)
        {
            Qery("SELECT * FROM view_students_exam");
        }

        private void button11_Click_1(object sender, EventArgs e)
        {
            table = "appraisal";
            button8.Visible = false;
            button4.Visible = false;
            button7.Visible = false;
            comboBox1.Visible = false;
            comboBox3.Visible = false;
            textBox3.Visible = false;
            textBox5.Visible = false;
            label3.Visible = false;
            label2.Visible = false;
            label7.Visible = false;
            label8.Visible = false;
            label9.Visible = false;
            label4.Visible = false;
            button12.Visible = false;
            button13.Visible = false;
            dateTimePicker1.Visible = false;
            dateTimePicker2.Visible = false;
            button14.Visible = false;
            button15.Visible = false;
            button16.Visible = false;
            label19.Visible = false;
            textBox2.Visible = false;
            label20.Visible = false;
            textBox6.Visible = false;
            textBox4.Visible = false;
            label10.Visible = false;
            label17.Visible = false;
            label18.Visible = false;
            textBox7.Visible = false;
            label5.Visible = false;
            View_true();
            label21.Visible = true;
            label22.Visible = true;
            label23.Visible = true;
            label24.Visible = true;
            label25.Visible = true;
            label26.Visible = true;
            comboBox6.Visible = true;
            comboBox7.Visible = true;
            comboBox8.Visible = true;
            comboBox9.Visible = true;
            comboBox10.Visible = true;
            comboBox11.Visible = true;
            Combobox(comboBox2, "SELECT id_rec FROM students_exam");
            Combobox(comboBox4, "SELECT id_rec FROM students_exam");
            FI(comboBox6, "SELECT name, surname FROM students");
            FI(comboBox11, "SELECT name, surname FROM students");
            Combobox(comboBox10, "SELECT name_exam FROM exam");
            Combobox(comboBox8, "SELECT name_exam FROM exam");
            Combobox(comboBox12, "SELECT id FROM students");
            Combobox(comboBox13, "SELECT id FROM exam");
            Qery("SELECT students_exam.id_rec, students.name,students.surname, exam.name_exam, students_exam.appraisal FROM students INNER JOIN students_exam ON students.id = students_exam.fk_id_student INNER JOIN exam ON students_exam.fk_id_exam = exam.id");
        }

        private void FI(ComboBox box, string textsql)
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
                //MessageBox.Show(list[1].ToString());
                arrCities[b] = list[0].ToString() + " " + list[1].ToString();
                b++;
            }

            box.Items.AddRange(arrCities);
            box.SelectedItem = box.Items[0];
        }

        private void comboBox9_SelectedIndexChanged(object sender, EventArgs e)
        {
        }
    }
}
