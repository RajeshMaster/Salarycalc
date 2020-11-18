Date : 2020-08-17 05:27:20
Path : C:\xampp\htdocs\Salarycalc\app\Http\Controllers\BasicCalcController.php
Line : 204
Message : Undefined offset: 0

Date : 2020-08-17 05:31:06
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										  ' at line 19 (SQL: select * from (SELECT invsal.id
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
											AND invsal.year =  
											AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year =  
											AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 05:31:40
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										  ' at line 19 (SQL: select * from (SELECT invsal.id
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
											AND invsal.year =  
											AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year =  
											AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 05:46:20
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										  ' at line 19 (SQL: select * from (SELECT invsal.id
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
											AND invsal.year =  
											AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year =  
											AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 07:49:18
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										  ' at line 19 (SQL: select * from (SELECT invsal.id
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
											AND invsal.year =  
											AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year =  
											AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:27:10
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:31:10
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:56:09
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:56:34
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:56:55
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:57:30
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:57:33
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 09:57:43
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalcplus.php
Line : 180
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as' at line 14 (SQL: select * from 
						(SELECT salemp.Emp_ID,
								invsal.id,
								invsal.date,
								invsal.year,
								invsal.month,
								invsal.Salary,
								invsal.Deduction,
								invsal.mailFlg,invsal.Travel,
								invsal.salamt FROM inv_salaryplus_main_emp AS salemp 
						LEFT JOIN inv_salaryplus_main AS invsal 
							ON invsal.Emp_ID = salemp.Emp_ID 
							AND invsal.year =  
							AND invsal.month=  
						WHERE salemp.year =  
							AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 10:43:56
Path : C:\xampp\htdocs\Salarycalc\app\Model\SalaryCalc.php
Line : 576
Message : SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										  ' at line 19 (SQL: select * from (SELECT invsal.id
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
											AND invsal.year =  
											AND invsal.month= 
										LEFT JOIN inv_basic_salary AS basic 
										    ON basic.Emp_ID = salemp.Emp_ID 
										    AND basic.activeFlg = 0 
										WHERE salemp.year =  
											AND salemp.month = ) as tbl order by `Emp_ID` asc)

Date : 2020-08-17 10:48:37
Path : C:\xampp\htdocs\Salarycalc\app\Http\Controllers\BasicCalcController.php
Line : 117
Message : Undefined offset: 0

Date : 2020-08-17 10:48:43
Path : C:\xampp\htdocs\Salarycalc\app\Http\Controllers\BasicCalcController.php
Line : 204
Message : Undefined offset: 0

Date : 2020-08-17 11:02:24
Path : C:\xampp\htdocs\Salarycalc\app\Http\Controllers\BasicCalcController.php
Line : 207
Message : Undefined offset: 0

Date : 2020-08-17 13:48:14
Path : C:\xampp\htdocs\Salarycalc\vendor\laravel\framework\src\Illuminate\Pagination\LengthAwarePaginator.php
Line : 49
Message : Division by zero

