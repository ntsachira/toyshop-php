<?php
if (!isset($_SESSION["admin"]["email"])) {
    ?>
    <script>
        window.location = "index.php";
    </script>
    <?php
}
?>
<!DOCTYPE html>

<html>

<body>
    <div class="row mb-3 align-items-start">
        <h1 class="col-9 col-lg-10 col-xl-11">Generate Reports</h1>
        <a href="home.php?tab=analytics" class="col ui button primary">Back</a>
    </div>

    <div class="row justify-content-center">
        <!-- left side -->
        <div class="col-12 col-md-4 mb-3 bg-white rounded border py-2">
            <div class="row">
                <div class="mb-3">
                    <label for="report-category " class="form-label fw-bold">Report Category</label>
                    <select name="" onchange="loadReportFormOnCategory();" class="form-select" id="report-category">
                        <option value="0">Select category</option>
                        <option value="inventory">Inventory Report</option>
                        <option value="sales">Sales Report</option>
                        <option value="customer">Customer Report</option>
                    </select>
                </div>
            </div>

            <div class="row" id="not-selected-note">
                <div class="col-12">
                    <span>Select a Category to continue...</span>
                </div>
            </div>

            <div class="row d-none" id="cat-inventory">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="">Report type</label>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" checked onchange="toggleSortInventory()"
                            type="radio" name="inventory-report-type" id="limited-stock">
                        <label class="form-check-label curser-pointer" for="limited-stock">Limited Stock report</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" onchange="toggleSortInventory()" type="radio"
                            name="inventory-report-type" id="out-of-stock">
                        <label class="form-check-label curser-pointer" for="out-of-stock">Out of Stock report</label>
                    </div>
                </div>
            </div>

            <div class="row d-none" id="cat-sales">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="sales-report-type">Report type</label>
                    <select class="form-select" name="" id="sales-report-type"
                        onchange="toggleFrequncySelectForSales();">
                        <option value="0">Select report type</option>
                        <option value="low selling">Low selling Products</option>
                        <option value="top selling">Top selling products</option>
                        <option value="by cutomer">Sales by customer</option>
                        <option value="by sales">Sales by category</option>
                        <option value="by product">Sales by product</option>
                    </select>
                </div>
            </div>

            <div class="row d-none" id="cat-customer">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="">Report type</label>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" onchange="toggleCustomerReportType()" checked
                            type="radio" name="customer-report-type" id="registered-customers">
                        <label class="form-check-label curser-pointer" for="registered-customers">Registered customers
                            List</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" onchange="toggleCustomerReportType()"
                            type="radio" name="customer-report-type" id="orders-list">
                        <label class="form-check-label curser-pointer" for="orders-list">Orders List</label>
                    </div>
                </div>
            </div>

            <div class="row d-none" id="order-status-fields">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="">Status</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" onchange="toggleCheckedStatus(true);" value=""
                            id="status-all">
                        <label class="form-check-label" for="status-all">
                            All
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="status-awaiting" onchange="toggleCheckedStatus();">
                        <label class="form-check-label" for="status-awaiting">
                            Awaiting Confirm
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="status-confirmed" onchange="toggleCheckedStatus();">
                        <label class="form-check-label" for="status-confirmed">
                            Confirmed
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="status-packaging" onchange="toggleCheckedStatus();">
                        <label class="form-check-label" for="status-packaging">
                            Packaging
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="status-out" onchange="toggleCheckedStatus();">
                        <label class="form-check-label" for="status-out">
                            Out For Delivery
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="status-delivered" onchange="toggleCheckedStatus();">
                        <label class="form-check-label" for="status-delivered">
                            Delivered
                        </label>
                    </div>
                </div>
            </div>            

            <div class="row d-none" id="range-fields">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="">Range</label>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" checked type="radio" name="range"
                            id="last-month">
                        <label class="form-check-label curser-pointer" for="last-month">Last month</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" type="radio" name="range" id="six-months">
                        <label class="form-check-label curser-pointer" for="six-months">Last 6 months</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" type="radio" name="range" id="last-year">
                        <label class="form-check-label curser-pointer" for="last-year">Last year</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" type="radio" name="range" id="two-year">
                        <label class="form-check-label curser-pointer" for="two-year">Last 2 years</label>
                    </div>
                </div>
            </div>

            <div class="row d-none" id="sort-fields">
                <div class="mb-3">
                    <label class="form-label fw-bold" for="">Sort</label>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" checked type="radio" name="sort"
                            id="default-sort">
                        <label class="form-check-label curser-pointer" for="default-sort">Default sort</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" type="radio" name="sort" id="asc-sort">
                        <label class="form-check-label curser-pointer" for="asc-sort">Accending</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input curser-pointer" type="radio" name="sort" id="desc-sort">
                        <label class="form-check-label curser-pointer" for="desc-sort">Descending</label>
                    </div>
                </div>
            </div>

            <div class="row d-none" id="generate-button">
                <div class="col-12">
                    <button class="ui button teal" onclick="generateReport();">Generate Report</button>
                </div>
            </div>
        </div>
        <!-- left side end -->

        <!-- right side -->
        <div class="col-12 col-md-8 mb-3 ps-4" style="min-height:40rem;max-height: 50rem;">
            <div class="row align-items-center h-100 ">
                <div id="report-content"
                    class="mb-2 col-12 border rounded border-2 border-black overflow-auto py-3 pb-5  bg-white  h-100 d-flex align-items-start justify-content-center">
                    <h4 class="">Your Report will be displayed here</h4>
                </div>                
            </div>
        </div>
        <!-- right side end -->
    </div>

</body>

</html>