$(document).ready(() => {
  $("#admin-login-btn").click(() => {
    $.post(
      "process/adminLoginProcess.php",
      {
        email: $("#admin-email").val(),
        password: $("#admin-password").val(),
        rememberme: document.getElementById("admin-rememberme").checked,
      },
      (res) => {
        console.log(res);
        let response = JSON.parse(res);
        if (response.status == "success") {
          window.location = "home.php?tab=dashboard";
        } else {
          alert(response.message);
        }
      }
    );
  });

  // sidebar funtionality
  if ($(this).width() < 768) {
    $("#loader").css({ "padding-left": "0rem" });
    $("#sidebar").width("0");
    $("#sidebar").hide();
  } else {
    $("#sidebar").show();
    $("#sidebar").width("13rem");
    $("#loader").css({ "padding-left": "14rem" });
  }

  $(window).resize(() => {
    if ($(this).width() < 768) {
      $("#loader").css({ "padding-left": "0rem" });
      $("#sidebar").width("0");
      $("#sidebar").hide();
    } else {
      $("#sidebar").show();
      $("#sidebar").width("13rem");
      $("#sidebar").removeClass("shadow");
      $("#loader").css({ "padding-left": "14rem" });
    }
  });

  $("#menu").click(() => {
    $("#sidebar").show();
    $("#sidebar").animate({ width: "13rem" }, () => {
      $("#sidebar").addClass("shadow");
    });
  });
  $("#close-sidebar").click(() => {
    $("#sidebar").animate({ width: "0" }, () => {
      $("#sidebar").removeClass("shadow");
      $("#sidebar").hide();
    });
  });

  // sidebar funtionality ends

  // dropdown menu functionality
  $("#menu-dropdown").dropdown({ action: "hide" });
  // dropdown menu functionality ends

  // logout functionality
  $("#logout-btn").click(() => {
    $.get("process/adminSignoutProcess.php", (res) => {
      let response = JSON.parse(res);
      if (response.status == "success") {
        window.location = "index.php";
      }
    });
  });
  // logout functionality ends

 
  
  // dropdown select
  $(".ui.dropdown").dropdown();

  // dropdown select ends

  // load image preview
  $("#updateProductImage").change(() => {
    let fileChooser = document.getElementById("updateProductImage");
    if (fileChooser.files.length > 3) {
      alert("You can only upload 3 images");
    } else {
      for (let i = 0; i < fileChooser.files.length; i++) {
        document.getElementById("productImage" + (3 - (i + 1))).src =
          window.URL.createObjectURL(fileChooser.files[i]);
      }
    }
  });
  // load image preview ends

  // add new color, brand, category, model
  $("#addNewBtn").click(() => {
    if ($("#modalTitle").text() == "Color") {
      addNewColor();
    } else if ($("#modalTitle").text() == "Brand") {
      addNewBrand();
    } else if ($("#modalTitle").text() == "Category") {
      addNewCategory();
    } else if ($("#modalTitle").text() == "Model") {
      addNewModel();
    }
  });
  // add new color, brand, category, model ends

  // add new color functionality
  const addNewColor = () => {
    $.get(
      "process/addNewSpecProcess.php?color=" + $("#newValueInput").val(),
      (res) => {
        let response = JSON.parse(res);
        if (response.status == "success") {
          $("#colorSelect").html(response.data);
          toggleModal("");
        } else {
          alert(response.message);
          $("#newValueInput").val("");
        }
      }
    );
  };

  // add new color functionality ends

  // add new brand functionality
  const addNewBrand = () => {
    $.get(
      "process/addNewSpecProcess.php?brand=" + $("#newValueInput").val(),
      (res) => {
        let response = JSON.parse(res);
        if (response.status == "success") {
          $("#brandSelect").html(response.data);
          toggleModal("");
        } else {
          alert(response.message);
          $("#newValueInput").val("");
        }
      }
    );
  };

  // add new brand functionality ends

  // add new category functionality
  const addNewCategory = () => {
    $.get(
      "process/addNewSpecProcess.php?category=" + $("#newValueInput").val(),
      (res) => {
        let response = JSON.parse(res);
        if (response.status == "success") {
          $("#categorySelect").html(response.data);
          toggleModal("");
        } else {
          alert(response.message);
          $("#newValueInput").val("");
        }
      }
    );
  };

  // add new category functionality ends

  // add new model functionality
  const addNewModel = () => {
    $.get(
      "process/addNewSpecProcess.php?model=" + $("#newValueInput").val(),
      (res) => {
        let response = JSON.parse(res);
        if (response.status == "success") {
          $("#modelSelect").html(response.data);
          toggleModal("");
        } else {
          alert(response.message);
          $("#newValueInput").val("");
        }
      }
    );
  };

  // add new model functionality ends

  // preview product image
  $("#addProductImage").change(() => {
    let fileChooser = document.getElementById("addProductImage");
    if (fileChooser.files.length > 3) {
      alert("You can only upload 3 images");
    } else {
      for (let i = 0; i < fileChooser.files.length; i++) {
        let preview = document.getElementById("imagePreview" + i);
        preview.src = window.URL.createObjectURL(fileChooser.files[i]);
      }
    }
  });

  $("#saveProductBtn").click(() => {
    let form = new FormData();
    form.append("category", $("#categorySelect").val());
    form.append("brand", $("#brandSelect").val());
    form.append("model", $("#modelSelect").val());
    form.append("color", $("#colorSelect").val());
    form.append("title", $("#productTitle").val());

    if (document.getElementById("inlineRadio1").checked) {
      form.append("condition", $("#inlineRadio1").val());
    } else if (document.getElementById("inlineRadio2").checked) {
      form.append("condition", $("#inlineRadio2").val());
    } else if (document.getElementById("inlineRadio3").checked) {
      form.append("condition", $("#inlineRadio3").val());
    }

    form.append("description", $("#description").val());
    form.append("deliveryWithin", $("#deliveryWithin").val());
    form.append("deliveryOut", $("#deliveryOut").val());
    form.append("quantity", $("#productQuantity").val());
    form.append("price", $("#productPrice").val());

    let fileChooser = document.getElementById("addProductImage");
    if (fileChooser.files.length > 3) {
      for (let x = 0; x < fileChooser.files.length; x++) {
        form.append("productImage" + x, fileChooser.files[x]);
        if (x == 2) {
          break;
        }
      }
      alert("You can only upload 3 images");
    } else if (fileChooser.files.length != 0) {
      for (let i = 0; i < fileChooser.files.length; i++) {
        form.append("productImage" + i, fileChooser.files[i]);
      }
    }

    $.ajax({
      url: "process/addProductProcess.php",
      type: "POST",
      data: form,
      contentType: false,
      processData: false,
      success: (res) => {
        console.log(res);
        let response = JSON.parse(res);
        if (response.status == "success") {
          alert(response.message);
          window.location.reload();
        } else if (response.status == "faild") {
          alert(response.message);
        } else {
          alert(res);
        }
      },
    });
  });
}); // document ready ends

// update product functionality
const updateProduct = (id) => {
  let form = new FormData();
  form.append("title", $("#productTitle").val());
  form.append("description", $("#productDescription").val());
  form.append("deliveryWithin", $("#deliveryWithin").val());
  form.append("deliveryOut", $("#deliveryOut").val());
  form.append("quantity", $("#productQuantity").val());
  form.append("price", $("#productPrice").val());
  form.append("id", id);

  let fileChooser = document.getElementById("updateProductImage");
  if (fileChooser.files.length > 3) {
    for (let x = 0; x < fileChooser.files.length; x++) {
      form.append("productImage" + x, fileChooser.files[x]);
    }
    alert("You can only upload 3 images");
  } else if (fileChooser.files.length != 0) {
    for (let i = 0; i < fileChooser.files.length; i++) {
      form.append("productImage" + i, fileChooser.files[i]);
    }
  }

  $.ajax({
    url: "process/updateProductProcess.php",
    type: "POST",
    data: form,
    contentType: false,
    processData: false,
    success: (res) => {
      let response = JSON.parse(res);
      if (response.status == "success") {
        alert(response.message);
        window.location = "home.php?tab=myProducts";
      } else {
        alert(response.message);
      }
    },
  });
};
// update product functionality ends

// toggle product status
const toggleProductStatus = (id) => {
  $.get("process/toggleProductStatusProcess.php?id=" + id, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      alert(response.message);
      window.location.reload();
    } else {
      alert(response.message);
    }
  });
};
// toggle product status ends

// open add new color modal
function toggleModal(title) {
  $(".ui.modal")
    .modal({
      blurring: true,
    })
    .modal("toggle");
  $("#modalTitle").text(title);
}
// open add new color modal ends

// admin search product
$("#productSearchBtn").click(() => {
  let searchKey = $("#searchKeyInput").val();
  let sort = $("#sortOption").val();
  let condition = $("#conditionSelect").val();
  let category = $("#categorySelect").val();
  let brand = $("#brandSelect").val();
  let model = $("#modelSelect").val();

  window.location =
    "home.php?tab=myProducts&searchKey=" +
    searchKey +
    "&sort=" +
    sort +
    "&condition=" +
    condition +
    "&category=" +
    category +
    "&brand=" +
    brand +
    "&model=" +
    model;
});
// admin search product ends

//goto single product view
const gotoSingleProductView = (id, userType) => {
  $.get("../process/setProductSessionProcess.php?id=" + id, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      window.location = "../singleProductView.php?userType=" + userType;
    } else if (response.status == "faild") {
      alert(response.message);
    } else {
      alert(res);
    }
  });
};
//goto single product view ends

// set large image
const setLargeImage = (url) => {
  document.getElementById("largeImagePreview").src = url;
};


function loadChart() {
  const ctx = document.getElementById("myChart");

  $.get("process/loadUserChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let month = [];
      let userCount = [];

      chartData.forEach((monthData) => {
        month.push(monthData.month);
        userCount.push(monthData.count);
      });

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: month,
          datasets: [
            {
              label: "New Users",
              data: userCount,
              borderWidth: 1,
              backgroundColor: "#1f8daf",
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
              },
            },
          },
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load chart ends

// load sales chart
function loadSalesChart() {
  const ctx = document.getElementById("salesChart");

  $.get("process/loadSalesChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let month = [];
      let userCount = [];
   
      chartData.forEach((monthData) => {       
        month.push(monthData.month);
        userCount.push(monthData.total);        
      
      });

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: month,
          datasets: [
            {
              label: "Sales",
              data: userCount,
              borderWidth: 1,
              backgroundColor: "#023047",
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 15000,
              },
            },
          },
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load chart ends

// category sales chart

function loadCategorySalesChart() {
  const ctx = document.getElementById("categorySalesChart");

  $.get("process/loadCategoryChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let category = [];
      let categoryCount = [];

      const colors = [];

      for (let i = 0; i < chartData.length; i++) {
        const randomColor =
          "#" + Math.floor(Math.random() * 16777215).toString(16);
        colors.push(randomColor);
      }

      chartData.forEach((categoryData) => {
        category.push(categoryData.name);
        categoryCount.push(categoryData.count);
      });

      new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: category,
          datasets: [
            {
              label: "Products",
              data: categoryCount,
              borderWidth: 1,
              backgroundColor: colors,
            },
          ],
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load chart ends


// toggle User status
const toggleUserStatus = (email) => {
  $.get("process/toggleUserStatusProcess.php?email=" + email, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      alert(response.message);
      window.location.reload();
    } else {
      alert(response.message);
    }
  });
};
// toggle User status ends

var user_email;
const openMessage = (email,name)=>{ 
  $('#message-modal').modal('setting', 'closable', false).modal('show');
  setLoadMessages();
  user_email = email;
  $("#user-name").text(name);
  setInterval(setLoadMessages,100);
  updateSeenStatus(email);
};
function setLoadMessages(){
  loadMessages(user_email);
}
const closeModal = (id)=>{ 
  $('#message-modal').modal('hide');
  clearInterval(setLoadMessages);
  window.location.reload();
};

const updateSeenStatus = (email)=>{
  $.get(
    "process/updateSeenStatusProcess.php?email="+email,
    (res)=>{
   
    },
  );
};


const loadMessages = (email)=>{
  $.get(
    "process/loadMessagesProcess.php?email="+email,
    (res)=>{
      $("#message-container").html(res);
      $("#user-image").attr('src',$("#chat-user-image").attr("src"));
      scrollMessageModal();
    },
  );
};


  $("#send-btn").addClass("disabled");
  $("#message-text").keyup(function () {
    
    let textLength = $(this).val().trim().length;    
    document.getElementById("limit-value").innerHTML = textLength ;

    if (textLength >= 500) {
      $("#input-container").addClass("error");
      $("#send-btn").addClass("disabled");
    } else if(textLength != 0) {
      $("#input-container").removeClass("error");
      $("#send-btn").removeClass("disabled");
    }else{
      $("#send-btn").addClass("disabled");
    }

  });

  $("#send-btn").click(()=>{
    let form = new FormData();
    form.append("message", $("#message-text").val());
    form.append('email',user_email);
  
    $.ajax({
      url: "process/sendMessageProcess.php",
      type: "POST",
      data: form,
      contentType: false,
      processData: false,
      success: (res) => {
        let response = JSON.parse(res);
        if (response.status == "success") {
          $("#message-text").val("");
          $("#limit-value").text("0");
          // loadMessages();
         
        } else {
          alert(response.message);
        }
      },
    });
  });

  const scrollMessageModal = ()=>{ 
    let scroll = document.getElementById("message-scroll");
    $(scroll).css("scroll-behavior","smooth");
    scroll.scrollTo(0,scroll.scrollHeight);
 
 };

const loadMessageCount = ()=>{
  $.get(
    "process/loadMessageCountProcess.php",
    (res)=>{
      $("#message-count").text(res);      
    },
  );
 };

 setInterval(loadMessageCount,2000);

 var invoice_id;
 const openInvoice = (ship,total,subtotal,invoiceID)=>{ 
  
  $('#invoice-modal').modal('setting', 'closable', false).modal('show');
  $("#invoice-id").text("Order "+invoiceID);
  $("#inv-total").text("Rs. "+total+".00");
  $("#shipping-fee").text("Rs. "+ship+".00");
  $("#sub-total").text("Rs. "+subtotal+".00");
  loadInvoiceDataToModal(invoiceID);
  invoice_id = invoiceID;
 }

 const closeInvoice = ()=>{ 
  $('#invoice-modal').modal('hide'); 
};

const updateOrderStatus = ()=>{
  let form = new FormData();
  form.append("id",invoice_id);
  form.append("status",$("#order-status").val())
  $.ajax({
    url:"process/updateOrderStatus.php",
    type:"POST",
    data:form,
    contentType:false,
    processData:false,
    success:(res)=>{
      let response = JSON.parse(res);
      if(response.status == "success"){
          alert(response.message);
          window.location.reload();
      }else{
        alert(response.message);
      }
    },
  }
  );
};

const loadInvoiceDataToModal= (invoiceID)=>{
  $.get("process/loadInvoiceModalProcess.php?id="+invoiceID,(res)=>{
    // alert(res);
    $("#invoice-container").html(res);
  },);
};

const confirmOrder = (id)=>{
  let form = new FormData();
  form.append("id",id);
  form.append("status",4)
  $.ajax({
    url:"process/updateOrderStatus.php",
    type:"POST",
    data:form,
    contentType:false,
    processData:false,
    success:(res)=>{
      let response = JSON.parse(res);
      if(response.status == "success"){
          alert(response.message);
          window.location.reload();
      }else{
        alert(response.message);
      }
    },
  }
  );
};

//open check review modal functionality

function openCheckReviewModal(product_id){
  $('#check-review-modal'+product_id)
  .modal('show')
;
loadCheckReviewModal(product_id,1);
}

function loadCheckReviewModal(product_id,page){
  $.get("process/loadCheckReviewProcess.php?id="+product_id+"&page="+page,
  (res)=>{
    $("#product-reviews-container"+product_id).html(res);
  }
  )
}

//search orders
$("#invoice-status-select").change(()=>{
 searchOrders();
});


function searchOrders(){
  let status = document.getElementById("invoice-status-select").value;
  let date = document.getElementById("order-date").value;
  let order_id = document.getElementById("order-id").value;
  let customer = document.getElementById("customer-name").value;

  window.location = "home.php?tab=orders&status="+status+"&date="+date+"&id="+order_id+"&cus="+customer;
}

//search customers
function searchCustomers(){
  let customer = document.getElementById("search-text").value;
  window.location = "home.php?tab=customers&key="+customer;  
}


//open customer view modal functionality

function openCustomerViewModal(mobile){
  $('#view-cutomer-modal'+mobile)
  .modal('toggle')
;
}


// customer status pie chart

function customerStatusChart() {
  const ctx = document.getElementById("customerStatusChart");

  $.get("process/loadCustomerStatusChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let status = [];
      let statusCount = [];

      const colors = [];

      for (let i = 0; i < chartData.length; i++) {
        const randomColor =
          "#" + Math.floor(Math.random() * 16777215).toString(16);
        colors.push(randomColor);
      }

      chartData.forEach((statusData) => {
        status.push(statusData.name);
        statusCount.push(statusData.count);
      });

      new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: status,
          datasets: [
            {
              label: "Users",
              data: statusCount,
              borderWidth: 1,
              backgroundColor: colors,
            },
          ],
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load customer status pie chart ends

// orderStatusChart chart
function orderStatusChart() {
  const ctx = document.getElementById("orderStatusChart");

  $.get("process/loadOrderStatusChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let order = [];
      let orderCount = [];

      const colors = [];

      for (let i = 0; i < chartData.length; i++) {
        const randomColor =
          "#" + Math.floor(Math.random() * 16777215).toString(16);
        colors.push(randomColor);
      }

      chartData.forEach((orderData) => {
        order.push(orderData.name);
        orderCount.push(orderData.count);
      });

      new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: order,
          datasets: [
            {
              label: "Orders",
              data: orderCount,
              borderWidth: 1,
              backgroundColor: colors,
            },
          ],
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load customer status pie chart ends

// revernue By Category Chart chart
function revernueByCategoryChart() {
  const ctx = document.getElementById("revernueByCategoryChart");

  $.get("process/loadRevernueByCategoryChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let category = [];
      let categoryCount = [];

      const colors = [];

      for (let i = 0; i < chartData.length; i++) {
        const randomColor =
          "#" + Math.floor(Math.random() * 16777215).toString(16);
        colors.push(randomColor);
      }

      chartData.forEach((categoryData) => {
        category.push(categoryData.name);
        categoryCount.push(categoryData.count);
      });

      new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: category,
          datasets: [
            {
              label: "Revernue Rs",
              data: categoryCount,
              borderWidth: 1,
              backgroundColor: colors,
            },
          ],
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load revernue By Category Chart ends

// load total Order Chart
function totalOrderChart() {
  const ctx = document.getElementById("totalOrdersChart");

  $.get("process/loadOrdersChartProcess.php", (res) => {
    let response = JSON.parse(res);

    if (response.status == "success") {
      let chartData = response.data;

      let month = [];
      let userCount = [];
   
      chartData.forEach((monthData) => {       
        month.push(monthData.month);
        userCount.push(monthData.total);        
      
      });

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: month,
          datasets: [
            {
              label: "Orders",
              data: userCount,
              borderWidth: 1,
              backgroundColor: "#1f8da8",
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 2,
              },
            },
          },
        },
      });
    } else {
      alert(response.message);
    }
  });
}
// load chart ends

// loadLimitedStockProcess
function loadLimitedStock(page){
  $.get("process/loadLimitedStockProcess.php?page="+page,(res)=>{$("#limited-stock-container").html(res)});
}

// loadSoldOutProcess
function loadSoldOut(page){
  $.get("process/loadSoldOutProcess.php?page="+page,(res)=>{$("#sold-out-container").html(res)});
}

//new category
function openAddNewCategory(){
  let name = prompt("Please Enter New Category Name Here");
  if(name != null){
    
    $.get(
      "process/loadAllCategoriesProcess.php?cat="+name,
      (res)=>{
        console.log(res);
        let response = JSON.parse(res);
        if(response.status == "success"){
          window.location.reload();
        }else{
          alert(response.message);
        }
      }
    );
    
  }
}

// toggle cat modal
function toggleCatModal(id){
  $("#cat-modal"+id).modal('toggle');
}

// set cat image
var catImage = "";
function setCatImage(id){
  catImage = document.getElementById("cat-image-chooser"+id).files[0];  
  document.getElementById("cat-upload-image"+id).src = window.URL.createObjectURL(catImage);   
}

function updateCategory(id){
  let form = new FormData();
  if(catImage != ""){
    form.append("image",catImage);
  }  
  form.append("id",id);
  form.append("name",$("#cat-name"+id).val());

  $.ajax({
    url:"process/updateCategoryProcess.php",
    type: "POST",
    data: form,
    contentType:false,
    processData:false,
    success:(res)=>{
      console.log(res);
      let response = JSON.parse(res);
      if(response.status == 'success'){
        alert(response.message);
        window.location.reload();
      }else{
        alert(response.message);
      }
    },
  });
}

// updateSiteData

function updateSiteData(){
  $("#general-save-button").addClass("loading");
  let form = new FormData();

  form.append("name",$("#site-name").val());
  form.append("email",$("#contact-email").val());
  form.append("tele",$("#tele").val());
  form.append("mission",$("#mission").val());
  form.append("copy",$("#copy").val());
  form.append("address",$("#address").val());

  $.ajax({
    url:"process/updateSiteDataProcess.php",
    type:"POST",
    data:form,
    contentType:false,
    processData:false,
    success:(res)=>{
      console.log(res);
      let response = JSON.parse(res);
      if(response.status == "success"){
        alert(response.message);
        window.location.reload();
      }else{
        alert(response.message);
        $("#general-save-button").removeClass("loading");
      }
    },
  });
}

// reset password functinality

function resetAdminPassword(){  
  $("#submit-button").addClass("loading");
  let new_password = $("#new-pass").val();
  let re_enter_password = $("#re-pass").val()

  getOtp(new_password,re_enter_password);
}

function getOtp(new_password,re_enter_password){
  let form = new FormData();  
  form.append("new",new_password);
  form.append("reNew",re_enter_password); 

  $.ajax({
    url:"process/sendOtpProcess.php",
    type:"POST",
    data:form,
    contentType:false,
    processData:false,
    success:(res)=>{
    console.log(res);
    let response = JSON.parse(res);
    if(response.status == "success"){      
      alert(response.message);
      let otp = prompt("Please enter the OTP which has been sent to your email, to Continue");
      if(otp != null){
        $("#submit-button").addClass("loading");
        updatePassword(otp,new_password,re_enter_password);
      } else{
        $("#submit-button").removeClass("loading");
        $("#submit-button").text("Submit");
      }     
    }else{
      alert(response.message);
      $("#submit-button").removeClass("loading");
    }
  }});
}

function updatePassword(otp,new_password,re_enter_password){
  let form = new FormData();
  form.append("otp",otp);  
  form.append("new",new_password);
  form.append("reNew",re_enter_password);

  $.ajax({
    url:"process/resetPasswordProcess.php",
    type:"POST",
    data:form,
    contentType:false,
    processData:false,
    success:(res)=>{
      let response = JSON.parse(res);
      if(response.status = "success"){
        $("#submit-button").removeClass("loading");
        $("#submit-button").text("Successfully Updated");
        alert(response.message);
        $("#submit-button").text("Submit");
      }else{
        alert(response.message);
        $("#submit-button").removeClass("loading");
        $("#submit-button").text("Submit");
      }
    },
  });
}

// toggleOtpLogin
function toggleOtpLogin(){
  $("#loader1").addClass("active");
  $.get("process/toggleOtpLoginProcess.php",(res)=>{
    console.log(res);
    let response = JSON.parse(res);
    if(response.status == "success1"){
      $("#otp-info-label").text(response.message);             
      $("#loader1").removeClass("active");
    }else if(response.status == "success2"){
      $("#otp-info-label").text(response.message);
      $("#otp-info-label").attr("class","text-secondary");      
      $("#loader1").removeClass("active");
    }else{
      alert(response.message);
      $("#loader1").removeClass("active");
    }
  });
}

// update admin account
function updateAdmin(){
  $("#name-save-button").addClass("loading");
  let fname = $("#first-name").val();
  let lname = $("#last-name").val();

  $.get("process/updateAdminProcess.php?fname="+fname+"&lname="+lname,
  (res)=>{
    console.log(res);
    let response = JSON.parse(res);
    if(response.status=="success"){
      alert(response.message);
      $("#name-save-button").removeClass("loading");
      $("#name-save-button").text("Saved");
      window.location.reload();
    }else{
      alert(response.message);
      $("#name-save-button").removeClass("loading");
    }
  }
  );
}

// het login otp
function getLoginOtp(){
  $("#admin-otp-btn").text("Loading...");
  $("#otp-login-spinner").removeClass("d-none");
  $.get("process/getLoginOtpProcess.php",(res)=>{
    console.log(res);
    let response = JSON.parse(res);
    if(response.status=="success"){
      alert(response.message);
      let otp = prompt("Please enter the OTP which has been sent to your email, to Continue");
      if(otp != null){                
        otpLogin(otp);
      } else{
        $("#admin-otp-btn").text("Get Log in OTP"); 
        $("#otp-login-spinner").addClass("d-none");       
      }  
    }else{
      alert(response.message);
      $("#admin-otp-btn").text("Get Log In OTP");
      $("#otp-login-spinner").addClass("d-none"); 
    }
  });
}

function otpLogin (otp) { 
  let form = new FormData();
  form.append("otp",otp);  
  $.ajax({
    url:"process/otploginProcess.php",
    type:"POST",
    data:form,
    contentType:false,
    processData:false,
    success:(res)=>{
      console.log(res);
      let response = JSON.parse(res);
    if(response.status=="success"){
      window.location = "home.php?tab=dashboard";
    }else{
      alert(response.message);
      $("#admin-otp-btn").text("Get Log In OTP");
      $("#otp-login-spinner").addClass("d-none");
    }
    },
  });
 }

//  load admin log in history
function loadAdminLoginHistory(page){
  $.get("process/loadAdminLoginHistoryProcess.php?page="+page,
  (res)=>{
    $("#login-history-container").html(res);
  }
  );
}

// toggleCategoryStatus
function toggleCategoryStatus(id){
  $("#cat-status-spinner"+id).removeClass("d-none");
  $.get("process/toggleCategoryStatusProcess.php?id="+id,
  (res)=>{
    let response = JSON.parse(res);
    if(response.status == "success"){
      $("#cat-label"+id).text(response.message);     
      if(response.message=="Activated"){
        $("#cat-label"+id).addClass("text-success"); 
        $("#cat-label"+id).removeClass("text-danger"); 
      }else{
        $("#cat-label"+id).addClass("text-danger"); 
        $("#cat-label"+id).removeClass("text-success"); 
      }
    }else{
      alert(response.message);
    }
    $("#cat-status-spinner"+id).addClass("d-none");
  }
  );
}

//........................................................

var sortDiv = document.getElementById("sort-fields");
var rangeDiv = document.getElementById("range-fields");
var orderStatusDiv = document.getElementById("order-status-fields");
var generateButtonDiv = document.getElementById("generate-button");
function loadReportFormOnCategory(){
  let notSelectedNoteDiv = document.getElementById("not-selected-note");
  let inventoryFormDiv = document.getElementById("cat-inventory");
  let salesFormDiv = document.getElementById("cat-sales");
  let customerFormDiv = document.getElementById("cat-customer");  

  switch(document.getElementById("report-category").value){
    case "0":
      notSelectedNoteDiv.classList.remove("d-none");
      inventoryFormDiv.classList.add("d-none");
      salesFormDiv.classList.add("d-none");
      customerFormDiv.classList.add("d-none");      
      sortDiv.classList.add("d-none");      
      rangeDiv.classList.add("d-none");      
      orderStatusDiv.classList.add("d-none");         
      generateButtonDiv.classList.add("d-none");      
      break;
    case "inventory":
      notSelectedNoteDiv.classList.add("d-none");
      inventoryFormDiv.classList.remove("d-none");
      sortDiv.classList.remove("d-none");
      generateButtonDiv.classList.remove("d-none");
      salesFormDiv.classList.add("d-none");      
      rangeDiv.classList.add("d-none");
      orderStatusDiv.classList.add("d-none");
      customerFormDiv.classList.add("d-none");
      if(document.getElementById("out-of-stock").checked){
        sortDiv.classList.add("d-none");
      }
      break;
    case "sales":
      notSelectedNoteDiv.classList.add("d-none");
      inventoryFormDiv.classList.add("d-none");
      salesFormDiv.classList.remove("d-none");
      sortDiv.classList.add("d-none");
      generateButtonDiv.classList.add("d-none");      
      orderStatusDiv.classList.add("d-none");
      rangeDiv.classList.add("d-none");
      customerFormDiv.classList.add("d-none");
      document.getElementById("sales-report-type").value = "0";
      break;
    case "customer":
      notSelectedNoteDiv.classList.add("d-none");
      inventoryFormDiv.classList.add("d-none");
      salesFormDiv.classList.add("d-none");
      rangeDiv.classList.remove("d-none");
      customerFormDiv.classList.remove("d-none");
      sortDiv.classList.add("d-none");     
      generateButtonDiv.classList.remove("d-none");
      document.getElementById("registered-customers").checked = true;
      break;
  }
}

function toggleSortInventory(){
  if(document.getElementById("limited-stock").checked){
    sortDiv.classList.remove("d-none");
  }else if(document.getElementById("out-of-stock").checked){
    sortDiv.classList.add("d-none");
  }
}

function toggleFrequncySelectForSales(){
  switch(document.getElementById("sales-report-type").value){
    case "0":      
      rangeDiv.classList.add("d-none");
      sortDiv.classList.add("d-none");
      generateButtonDiv.classList.add("d-none");
      break;
    case "low selling":      
      rangeDiv.classList.remove("d-none");
      sortDiv.classList.add("d-none");
      generateButtonDiv.classList.remove("d-none");
      break;
    case "top selling":      
      rangeDiv.classList.remove("d-none");
      sortDiv.classList.add("d-none");
      generateButtonDiv.classList.remove("d-none");
      break;
    case "by cutomer":      
      rangeDiv.classList.remove("d-none");
      sortDiv.classList.remove("d-none");
      generateButtonDiv.classList.remove("d-none");
      break;
    case "by sales":      
      rangeDiv.classList.remove("d-none");
      sortDiv.classList.remove("d-none");
      generateButtonDiv.classList.remove("d-none");
      break;
    case "by product":      
      rangeDiv.classList.remove("d-none");
      sortDiv.classList.remove("d-none");
      generateButtonDiv.classList.remove("d-none");
      break;    
  }
}

function toggleCustomerReportType(){
  if(document.getElementById("registered-customers").checked){
    rangeDiv.classList.remove("d-none");      
    sortDiv.classList.add("d-none");    
    generateButtonDiv.classList.remove("d-none");
    orderStatusDiv.classList.add("d-none");
  }else if(document.getElementById("orders-list").checked){
    rangeDiv.classList.add("d-none");      
    sortDiv.classList.add("d-none");    
    generateButtonDiv.classList.remove("d-none");
    orderStatusDiv.classList.remove("d-none");
  }
}

function toggleCheckedStatus(isAll){
    let awaiting = document.getElementById("status-awaiting");
    let confirmed = document.getElementById("status-confirmed");
    let packaging = document.getElementById("status-packaging");
    let out = document.getElementById("status-out");
    let delivered = document.getElementById("status-delivered");

  if(isAll){
    if(document.getElementById("status-all").checked){
      awaiting.checked = true;
      confirmed.checked = true;
      packaging.checked = true;
      out.checked = true;
      delivered.checked = true;
    }else{
      awaiting.checked = false;
      confirmed.checked = false;
      packaging.checked = false;
      out.checked = false;
      delivered.checked = false;
    }
  }

  if(awaiting.checked && confirmed.checked && packaging.checked 
    && out.checked && delivered.checked){
      document.getElementById("status-all").checked = true;
  }else{
    document.getElementById("status-all").checked = false;
  }
}

function matchFrequencyTORange(){ 
  if(document.getElementById("annually").checked){
    document.getElementById("last-month").disabled = true;
    document.getElementById("last-month").checked = false;
    document.getElementById("six-months").disabled = true;
    document.getElementById("six-months").checked = false;
  }else{
    document.getElementById("last-month").disabled = false;
    document.getElementById("six-months").disabled = false;
  }
}

function generateReport(){
  let category = document.getElementById("report-category").value;

  if(category == "inventory"){
    loadInventoryReport();
  }else if(category == "sales"){
    loadSalesReport();
  }else if(category == "customer"){
    loadCustomerReport();
  }
}

function loadSalesReport(){
  let range = "month";
  let sort = "default";

    // range
    if(document.getElementById("six-months").checked){
      range = "six_months";
    }else if(document.getElementById("last-year").checked){
      range = "last_year";
    }else if(document.getElementById("two-year").checked){
      range = "two_years";
    }   

    // sort
    if(document.getElementById("asc-sort").checked){
      sort = "ASC";
    }else if(document.getElementById("desc-sort").checked){
      sort = "DESC";
    }

  switch(document.getElementById("sales-report-type").value){
    case "low selling":
      $.get(
        "process/loadLowSellingReport.php?range="+range,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
      break;
    case "top selling":
      $.get(
        "process/loadTopSellingReport.php?range="+range,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
      break;
    case "by cutomer":
      $.get(
        "process/loadSalesByCustomer.php?range="+range+"&sort="+sort,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
      break;
    case "by sales":
      $.get(
        "process/loadSalesByCategory.php?range="+range+"&sort="+sort,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
      break;
    case "by product":
      $.get(
        "process/loadSalesByProduct.php?range="+range+"&sort="+sort,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
      break;
  }
}


function loadInventoryReport(){   
  
  if(document.getElementById("limited-stock").checked){    
    let sort = "default";
    if(document.getElementById("asc-sort").checked){
      sort = "ASC";
    }else if(document.getElementById("desc-sort").checked){
      sort = "DESC";
    }
    $.get(
      "process/loadLimitedStockReport.php?sort="+sort,
      (res)=>{        
        document.getElementById("report-content").innerHTML = res;
      },
    );
    
  }else if(document.getElementById("out-of-stock").checked){
    $.get(
      "process/loadOutOfStockReport.php",
      (res)=>{        
        document.getElementById("report-content").innerHTML = res;
      },
    );
  }
}

function printReport(){
  let body = $("body").html();
  $("#report-print-btn").addClass("d-none");
  $("body").html($("#report-content").html());
  window.print();
  
  window.location.reload();
}

function loadCustomerReport(){
  let range = "month";  
  let status = [""];

    // range
    if(document.getElementById("six-months").checked){
      range = "six_months";
    }else if(document.getElementById("last-year").checked){
      range = "last_year";
    }else if(document.getElementById("two-year").checked){
      range = "two_years";
    } 

    //status
   
      if(document.getElementById("status-awaiting").checked){
        status.push("'Awaiting Confirm'");       
      }
      if(document.getElementById("status-confirmed").checked){
        status.push("'Confirmed'");       
      }
      if(document.getElementById("status-packaging").checked){
        status.push("'Packaging'");       
      }
      if(document.getElementById("status-out").checked){
        status.push("'Out for Delivery'");        
      }
      if(document.getElementById("status-delivered").checked){
        status.push("'Delivered'");        
      }
  


    //load report
    if(document.getElementById("registered-customers").checked){
      $.get(
        "process/loadregisteredCustomersReport.php?range="+range,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
    }else if(document.getElementById("orders-list").checked){
      // alert(status.join(","));
      $.get(
        "process/loadOrderListReport.php?status="+status,
        (res)=>{        
          document.getElementById("report-content").innerHTML = res;
        },
      );
    }
}

