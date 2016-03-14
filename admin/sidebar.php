<ul class="sidebar-menu">
                        <li class="active">
                            <a href="dashboard.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span>Mailbox</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="inbox.php"><i class="fa fa-angle-double-right"></i> Inbox</a></li>
                                <li><a href="draft.php"><i class="fa fa-angle-double-right"></i> Drafts</a></li>
                                <li><a href="sent.php"><i class="fa fa-angle-double-right"></i> Sent</a></li>
                                <li><a href="junk.php"><i class="fa fa-angle-double-right"></i> Junk</a></li>
                               
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Members</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.php?reg_user"><i class="fa fa-angle-double-right"></i> Register Member</a></li>
								
								<li><a href="admin.php?view_user"><i class="fa fa-angle-double-right"></i> View Members</a></li>
                                
							</ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Loans</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.php?add_loan_cat"><i class="fa fa-angle-double-right"></i> Add Loan Categories</a></li>
								<li><a href="admin.php?add_int_rate"><i class="fa fa-angle-double-right"></i> Add Interest Rate </a></li>
								<li><a href="admin.php?throw"><i class="fa fa-angle-double-right"></i> Apply For Loan </a></li>
								<li><a href="admin.php?view_int_rate"><i class="fa fa-angle-double-right"></i> View Interest Rates </a></li>
                                <li><a href="admin.php?view_cat"><i class="fa fa-angle-double-right"></i> View Loan Categories</a></li>
								<li><a href="admin.php?app_loan"><i class="fa fa-angle-double-right"></i> View Applied Loans</a></li>
								<li><a href="admin.php?pay_history"><i class="fa fa-angle-double-right"></i> Payment History</a></li>
								
							           
							</ul>
                        </li>
						 <li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Savings</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.php?all_sav_cat"><i class="fa fa-angle-double-right"></i> Add Saving Categories</a></li>
								<li><a href="admin.php?view_sav_cat"><i class="fa fa-angle-double-right"></i> View Savings Categories </a></li>
								
								
							           
							</ul>
                        </li>
						<li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i>
                                <span>Ledger</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="admin.php?generate_ledger"><i class="fa fa-angle-double-right"></i> Run Deductions</a></li>
								<li><a href="admin.php?view_generated_ledger"><i class="fa fa-angle-double-right"></i> View Generated Ledger </a></li>
								
								
							           
							</ul>
                        </li>
						
						 <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>Chat</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../freichat/administrator/index.php"><i class="fa fa-angle-double-right"></i> Chat</a></li>
							           
							</ul>
                        </li>
                        
                       
                       <?php
					   if($_SESSION['pms_admin_role']=="manager"){
echo ' <li class="treeview">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>Admin</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="?add_admin"><i class="fa fa-angle-double-right"></i> Add Admin</a></li>
                                <li><a href="?view_admin"><i class="fa fa-angle-double-right"></i> View Admin</a></li>
                                
                            </ul>
                        </li>';
						}
					   ?>
                    </ul>
                