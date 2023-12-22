<ul class="nav navbar-nav">
<li class="dropdown">
	<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">People Management
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a href="add_people.php">Add People</a></li>
		<li><a href="view_people.php">View People</a></li>
		
		
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Nithyanidhanam
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a href="add_vazhipadu_items.php">Add/View Items</a></li>
		<li><a href="invoice_list.php">View Vazhipadu</a></li>
		<li><a href="create_invoice.php">Add Vazhipadu</a></li>
		
		
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Events & Sambhavana
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a href="add_events.php">Add/View Events</a></li>
		<li><a href="add_sambhavana_items.php">Add/View Sambhavana Items</a></li>
		<li><a href="create_sambhavana.php">Create Sambhavana</a></li>		
		<li><a href="sambhavana_list.php"> Sambhavana List</a></li>	
		<li><a href="sambhavana_items_list.php"> Sambhavana Items List By Invoice</a></li>	
		
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Communication
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a href="sms.php">Send SMS</a></li>
		<li><a href="email.php">Send Email</a></li>
		<li><a href="create_invoice.php">View Vazhipadu</a></li>
		<li><a href="create_sambhavana.php">Create Sambhavana</a></li>		
		<li><a href="sambhavana_list.php"> Sambhavana List</a></li>	
		<li><a href="sambhavana_items_list.php"> Sambhavana Items List</a></li>	
		
	</ul>
</li>
<li class="dropdown">
	<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Reports
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a href="invoice_list.php">View Events</a></li>
		<li><a href="invoice_list.php">View Sambhavana Items</a></li>
		<li><a href="create_invoice.php">View Vazhipadu Items</a></li>
		<li><a href="create_sambhavana.php">Vazhipadu List</a></li>	
		<li><a href="create_sambhavana.php">Vazhipadu Items List</a></li>		
		<li><a href="sambhavana_list.php"> Sambhavana List</a></li>	
		<li><a href="sambhavana_items_list.php"> Sambhavana Items List</a></li>	
		
	</ul>
</li>
<?php 
if($_SESSION['userid']) { ?>
	<li class="dropdown">
		<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Logged in <?php echo $_SESSION['user']; ?>
		<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="#">Account</a></li>
			<li><a href="action.php?action=logout">Logout</a></li>		  
		</ul>
	</li>
<?php } ?>
</ul>
<br /><br /><br /><br />