Date : 2020-08-14 12:33:21
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[HY000]: General error: 1036 Table 'C:\xampp\tmp\#sql13c4_17d_1' is read only (SQL: select * from (SELECT invsal.id
										    , invsal.date
										    , invsal.year
										    , invsal.month
										    , invsal.Salary
										    , invsal.Deduction
										    , invsal.Transferred
										    , invsal.mailFlg
										    , invsal.Basic
										    , invsal.hra
										    , invsal.train_daily
										    , invsal.others
										    , salemp.Emp_ID
										    , basic.mail_need
										FROM inv_salary_main_emp AS salemp 
										LEFT JOIN inv_salary_main AS invsal 
											ON invsal.Emp_ID = salemp.Emp_ID 
											AND invsal.year = 2020 
											AND invsal.month= 07
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year = 2020 
											AND salemp.month = 07) as tbl order by `Emp_ID` asc)

Date : 2020-08-14 12:35:03
Path : C:\xampp\htdocs\Salarycalc\storage\framework\views\cd7f2ddec14a850e24567f4e166455ad7b3a500b.php
Line : 384
Message : Undefined index: SD001 (View: C:\xampp\htdocs\Salarycalc\resources\views\salarycalc\index.blade.php)

