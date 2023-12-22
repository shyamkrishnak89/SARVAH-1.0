<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">
<li class="nav-item">
    <a class="nav-link " href="dashboard.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-people"></i><span>People</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="add_people.php">
          <i class="bi bi-circle"></i><span>Add People</span>
        </a>
      </li>
      <li>
        <a href="view_people.php">
          <i class="bi bi-circle"></i><span>View People</span>
        </a>
      </li>
      
    </ul>
  </li><!-- End People Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#nithya-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-cart-check"></i><span>Nithyanidhanam</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="nithya-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="create_invoice.php">
          <i class="bi bi-circle"></i><span>Add Vazhipadu</span>
        </a>
      </li>
      <li>
        <a href="invoice_list.php">
          <i class="bi bi-circle"></i><span>View Vazhipadu List</span>
        </a>
      </li>
      <li>
        <a href="add_vazhipadu_items.php">
          <i class="bi bi-circle"></i><span>Add Vazhipadu items</span>
        </a>
      </li>
      <li>
        <a href="invoice_items_list.php">
          <i class="bi bi-circle"></i><span>View Vazhipadu List items</span>
        </a>
      </li>
    </ul>
  </li><!-- End Nithyanidhanam Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#sambhavana-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-calendar-event"></i><span>Events & Sambhavana</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="sambhavana-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="add_events.php">
          <i class="bi bi-circle"></i><span>Add/View Events</span>
        </a>
      </li>
      <li>
        <a href="create_sambhavana.php">
          <i class="bi bi-circle"></i><span>Make Sambhavana</span>
        </a>
      </li>
      
      <li>
        <a href="sambhavana_search.php">
          <i class="bi bi-circle"></i><span>View Sambhavana</span>
        </a>
      </li>
      <li>
        <a href="sambhavana_items_list.php">
          <i class="bi bi-circle"></i><span>View Sambhavana items List</span>
        </a>
      </li>
      <li>
        <a href="add_sambhavana_items.php">
          <i class="bi bi-circle"></i><span>Add Sambhavana items</span>
        </a>
      </li>
    </ul>
  </li><!-- End Events & Sambhavana Nav -->
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-file-earmark-pdf"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="reports-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="view_people.php">
          <i class="bi bi-circle"></i><span>All People</span>
        </a>
      </li>
      
      <li>
        <a href="vazhipadu_items_list.php">
          <i class="bi bi-circle"></i><span>vazhipadu Items</span>
        </a>
      </li>
      <li>
        <a href="invoice_list.php">
          <i class="bi bi-circle"></i><span>Invoices</span>
        </a>
      </li>
      <li>
        <a href="invoice_search.php">
          <i class="bi bi-circle"></i><span>Invoices Search</span>
        </a>
      </li>
      <li>
        <a href="invoice_search_monthly.php">
          <i class="bi bi-circle"></i><span>Monthly Invoices</span>
        </a>
      </li>
      <li>
        <a href="sambhavana_list.php">
          <i class="bi bi-circle"></i><span>Sambhavana</span>
        </a>
      </li>
      <li>
        <a href="sambhavana_search.php">
          <i class="bi bi-circle"></i><span>Search Sambhavana</span>
        </a>
      </li>
      <li>
        <a href="events_report.php">
          <i class="bi bi-circle"></i><span>Events</span>
        </a>
      </li>
      <li>
        <a href="monthly_report.php">
          <i class="bi bi-circle"></i><span>This Month Report</span>
        </a>
      </li>
      <li>
        <a href="reports_dates.php">
          <i class="bi bi-circle"></i><span>Datewise Report</span>
        </a>
      </li>
      <li>
        <a href="daily_report.php">
          <i class="bi bi-circle"></i><span>Daily Report</span>
        </a>
      </li>
    </ul>
  </li><!-- End Reports Nav -->
  
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#log-finance" data-bs-toggle="collapse" href="#">
      <i class="bi bi-currency-rupee"></i><span>Finance</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="log-finance" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="add_incomes.php">
          <i class="bi bi-circle"></i><span>Add Income</span>
        </a>
      </li>
      <li>
        <a href="add_expenses.php">
          <i class="bi bi-circle"></i><span>Add Expense</span>
        </a>
      </li>
    </ul>
  </li><!-- End Finance Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed"  href="qr_code.php">
      <i class="bi bi-upc-scan"></i><span>QR Code</span>
    </a>
    
  </li><!-- End QR Nav -->
  
 
</ul>

</aside><!-- End Sidebar-->
