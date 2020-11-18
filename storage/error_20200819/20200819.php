Date : 2020-08-19 07:41:08
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[HY000]: General error: 1036 Table 'C:\xampp\tmp\#sqlb9c_3f_3' is read only (SQL: select * from (SELECT invsal.id
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

