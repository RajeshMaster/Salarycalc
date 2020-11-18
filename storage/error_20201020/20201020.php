Date : 2020-10-20 10:11:31
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[HY000]: General error: 29 File 'C:\xampp\tmp\#sql1364_10c_1.MYD' not found (Errcode: 13 - Permission denied) (SQL: select * from (SELECT invsal.id
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
											AND invsal.month= 09
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year = 2020 
											AND salemp.month = 09) as tbl order by `Emp_ID` asc)

Date : 2020-10-20 10:12:10
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 374
Message : Undefined variable: insert

Date : 2020-10-20 10:12:15
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 374
Message : Undefined variable: insert

