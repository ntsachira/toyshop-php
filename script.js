function changeView() {
  //toggle between sign up and sign in
  closeAlert();
  var signUpBox = document.getElementById("signUpBox");
  var signInBox = document.getElementById("signInBox");

  signUpBox.classList.toggle("d-none");
  signInBox.classList.toggle("d-none");
}

//This function send a POST request to the server and get the response as JSON
function postRequest(data, url, callback) {
  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.text())
    .then((data) => {
      callback(data);
    })
    .catch((error) => {
      console.error("Error:", error);
      alert(error.message);
    });
}

//This function send a GET request to the server and get the response as JSON
function getRequest(data, url, callback) {
  fetch(url + "?" + new URLSearchParams(data), {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.text())
    .then((data) => {
      callback(data);
    })
    .catch((error) => {
      console.error("Error:", error);
      alert(error);
    });
}

function signup() {
  var data = {
    firstname: document.getElementById("fname").value,
    lastname: document.getElementById("lname").value,
    email: document.getElementById("email").value,
    password: document.getElementById("password").value,
    mobile: document.getElementById("mobile").value,
    gender: document.getElementById("gender").value,
  };

  var url = "process/signupProcess.php";

  postRequest(data, url, (res) => {
    // alert(res); //remove this line after testing

    var response = JSON.parse(res); //convert the JSON string to JS object

    if (response.status == "success") {
      showAlert(response.message, "success"); //Unhide and display the alert
      resetUserInput(); // clear user input on a successfull registration
    } else {
      showAlert(response.message, "warning"); //Unhide and display the alert
    }
  });
}

function resetUserInput() {
  document.getElementById("fname").value = "";
  document.getElementById("lname").value = "";
  document.getElementById("email").value = "";
  document.getElementById("password").value = "";
  document.getElementById("mobile").value = "";
}

function showAlert(message, type) {
  if (message != null) {
    document.getElementById("msgText").innerHTML = message; //set the message

    if (type == "success") {
      document
        .getElementById("msg")
        .classList.replace("alert-warning", "alert-success");
    }
    if (type == "warning") {
      document
        .getElementById("msg")
        .classList.replace("alert-success", "alert-warning");
    }
    document.getElementById("msgdiv").classList.replace("d-none", "d-flex"); //unhide the alert
  }
}

function closeAlert() {
  document.getElementById("msgdiv").classList.add("d-none");
}

//* signin - This function is called when the user clicks on the sign in button
function signin() {
  var data = {
    email: document.getElementById("email2").value,
    password: document.getElementById("password2").value,
    rememberme: document.getElementById("rememberme").checked,
  };

  var url = "process/signinProcess.php";

  postRequest(data, url, (res) => {
    //  alert(res); //remove this line after testing

    var response = JSON.parse(res); //convert the JSON string to JS object

    if (response.status == "success") {
      window.location = "home.php";
    } else {
      showAlert(response.message, "warning"); //Unhide and display the alert
    }
  });
}

function forgotPassword() {
  $("#fogot-password-spinner").removeClass("d-none");
  var data = {
    email: document.getElementById("email2").value,
  };

  var url = "process/forgotPasswordProcess.php";

  getRequest(data, url, (res) => {
    //  alert(res); //remove this line after testing

    var response = JSON.parse(res); //convert the JSON string to JS object

    if (response.status == "success") {
      closeAlert();
      alert(response.message);
      $("#fogot-password-spinner").addClass("d-none");
      //open model to enter the code
      togglePasswordResetModal();
    } else {
      showAlert(response.message, "warning"); //Unhide and display the alert
    }
  });
}

var passwordResetMpdal = null; //global variable to hold the password reset modal

function togglePasswordResetModal() {
  //this function opens and closes the password reset modal
  if (passwordResetMpdal == null) {
    passwordResetMpdal = new bootstrap.Modal(
      document.getElementById("passwordResetModal")
    );
    passwordResetMpdal.show();
  } else {
    passwordResetMpdal.toggle();
  }
}

function toggleShowPassword(inputid, buttonid) {
  //id is the id of the password input field
  if (document.getElementById(inputid).type == "password") {
    document.getElementById(inputid).type = "text";
    document.getElementById(buttonid).innerHTML = "Hide";
  } else {
    document.getElementById(inputid).type = "password";
    document.getElementById(buttonid).innerHTML = "Show";
  }
}

function resetPassword() {
  data = {
    email: document.getElementById("email2").value,
    newPassword: document.getElementById("newPassword").value,
    reEnterPassword: document.getElementById("reEnterPassword").value,
    verificationCode: document.getElementById("verificationCode").value,
  };

  var url = "process/resetPasswordProcess.php";

  postRequest(data, url, (res) => {
    //  alert(res); //remove this line after testing

    var response = JSON.parse(res); //convert the JSON string to JS object

    if (response.status == "success") {
      togglePasswordResetModal();
      alert(response.message);
      window.location.reload();
    } else {
      document.getElementById("passwordresetModel-errorLabel").innerHTML =
        response.message; //set the message
      document
        .getElementById("passwordresetModel-errorLabelDiv")
        .classList.replace("d-none", "text-danger");
    }
  });
}

var headerDropdown = null;
function toggleHeaderDropdown() {
  var dropdown = document.getElementById("headerDropdown");
  headerDropdown = new bootstrap.Dropdown(dropdown);
  headerDropdown.show();
}

function signout() {
  getRequest(null, "process/signoutProcess.php", (res) => {
    // alert(res);
    var response = JSON.parse(res);
    if (response.status == "success") {
      window.location.reload();
    } else {
      alert("Something went wrong");
    }
  });
}

function gotoRegister() {
  window.location = "index.php";
  changeView();
}

function loadProfilePicture(inputId, previewId) {
  var file = document.getElementById(inputId).files[0];
  var reader = new FileReader();
  reader.readAsDataURL(file);
  reader.onload = function () {
    document.getElementById(previewId).src = reader.result;
  };
  // alert(file.name); //remove this line after testing
  reader.onerror = function (error) {
    alert("Error: ", error);
  };
}

function changeDistrictAndProvinceOnCity() {
  var data = {
    city_id: document.getElementById("city_select").value,
  };

  getRequest(
    data,
    "process/changeDistrictAndProvinceOnCityProcess.php",
    (res) => {
      // alert(res); //for testing
      var response = JSON.parse(res);
      if (response.status == "success") {
        document.getElementById("district").value = response.data.district;
        document.getElementById("province").value = response.data.province;
      }
    }
  );
}

function updateUserProfile() {
  var form = new FormData();

  form.append("image", document.getElementById("userImageSelect").files[0]);
  form.append("fname", document.getElementById("fname").value);
  form.append("lname", document.getElementById("lname").value);
  form.append("mobile", document.getElementById("mobile").value);
  form.append("line1", document.getElementById("line1").value);
  form.append("line2", document.getElementById("line2").value);
  form.append("city", document.getElementById("city_select").value);
  form.append("postalCode", document.getElementById("postalCode").value);

  fetch("process/updateUserProfileProcess.php", {
    method: "POST",
    body: form,
  })
    .then((response) => response.text())
    .then((data) => {
      // alert(data); //for testing
      var response = JSON.parse(data);
      if (response.status == "success") {
        window.location.reload();
      } else {
        showAlert(response.message, "warning");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert(error.message);
    });
}

//stickesy header
$(document).ready(function () {
  $(window).scroll(function () {
    var header = $("#header");
    if ($(document).scrollTop() > 50) {
      header.addClass("shadow");
    } else {
      header.removeClass("shadow");
    }
  });
});
//end of stickesy header

// set large image
const setLargeImage = (url) => {
  document.getElementById("largeImagePreview").src = url;
  $("#largeImagePreview").css({ "min-height": $("#imageContainer").width() });
  // alert(url);
};

//zoom image on hover
$("#imageParent").mousemove(function (e) {
  var offset = $(this).offset();
  let l = e.pageX - offset.left;
  let t = e.pageY - offset.top;

  $("#imageContainer").css({
    transform: "scale(2)",
    left: 350 - l * (1400 / (l + 600)) + "px",
    top: 350 - t * (1400 / (t + 583)) + "px",
  });
});

$("#imageParent").mouseleave(function () {
  $("#imageContainer").css({
    transform: "scale(1)",
    left: 0,
    top: 0,
  });
});
//end of zoom image on hover

//set large preview width value to its height
if ($("#imageContainer").width() < 488) {
  $("#largeImagePreview").css({
    "min-height": $("#imageContainer").width(),
    "max-height": $("#imageContainer").width(),
  });
} else {
  $("#largeImagePreview").css({ "min-height": 488 });
}

$(window).resize(() => {
  if ($("#imageContainer").width() < 488) {
    $("#largeImagePreview").css({
      "min-height": $("#imageContainer").width(),
      "max-height": $("#imageContainer").width(),
    });
  } else {
    $("#largeImagePreview").css({ "min-height": 488 });
  }
});
//set large preview width value to its height

// rating

const loadRating = (id) => {
  $.get("process/loadRatingProcess.php?id=" + id, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {      
      $('#total-rate ').rating('set rating', response.data.rate);
    }else{
      alert(response.message);
    }
   
  });
};
$("#total-rate")
.rating({
  initialRating: 0,
  maxRating: 5,
})
.rating("disable");
// rating
$("#userRating").rating({
  initialRating: 3,
  maxRating: 5,
});

function viewProduct(id, userType) {
  $.get("process/setProductSessionProcess.php?id=" + id, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      window.location = "singleProductView.php?userType=" + userType;
    } else if (response.status == "faild") {
      alert(response.message);
    } else {
      alert(res);
    }
  });
}

//toggle scroll to top button
$(document).ready(function () {
  $(window).scroll(function () {
    var pageUp = $("#pageUp");
    if ($(document).scrollTop() > document.documentElement.scrollHeight / 3) {
      pageUp.fadeIn();
    } else {
      pageUp.fadeOut();
    }
  });
  var pageUp = $("#pageUp");
  if ($(document).scrollTop() > document.documentElement.scrollHeight / 3) {
    pageUp.show();
  } else {
    pageUp.hide();
  }
});
//toggle scroll to top button

const loadProducts = (cat_id,isKey) => {
  let url = "loadProducts.php?cat=" + cat_id;
  if(isKey == true){
    if ($("#product-search-input").val().trim() != "") {
        url += "&key=" + $("#product-search-input").val();
      }
  }
  
  window.location = url;
};

// dropdown select
$(".ui.dropdown").dropdown({});

// dropdown select ends

$("#condition-drop").dropdown({
  onChange: function (value, text) {
    window.location = $(this).attr("uri") + "&cond=" + text;
  },
});
$("#price-drop").dropdown({
  onChange: function (value, text) {
    window.location = $(this).attr("uri") + "&price=" + text;
  },
});
$("#sort-drop").dropdown({
  onChange: function (value, text) {
    
    window.location = $(this).attr("uri") + "&sort=" + text;
  },
});

const toggleWatchList = (id) => {
  $.get("process/toggleWatchlistProcess.php?id=" + id, (res) => {
    console.log(res);
    let response = JSON.parse(res);
    if (response.status == "added") {
      $("#heart-icon" + id).toggleClass("text-danger");
    } else if (response.status == "removed") {
      window.location.reload();
    } else if (response.status == "faild") {
      alert(response.message);
      if(response.message == "Please Log In First"){
        window.location = "index.php";
      }
    }
  });
};

// addtocart
const addtoCart = (id, qty) => {
  $.get("process/addtoCartProcess.php?id=" + id + "&qty=" + qty, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      alert(response.message);
      window.location.reload();
    } else if (response.status == "faild") {
      alert(response.message);
      if(response.message == "Please Sign In First"){
        window.location = "index.php";
      }
    } else {
      alert(res);
    }
  });
};

const updateCart = (id) => {
  $.get(
    "process/updateCartProcess.php?id=" +
      id +
      "&qty=" +
      $("#cart-quantity" + id).val(),
    (res) => {
      let response = JSON.parse(res);
      if (response.status == "success") {
        window.location.reload();
      } else if (response.status == "faild") {
        alert(response.message);
      } else if (response.status == "log") {
        alert(response.message);
        window.location = "index.php";
      } else {
        alert(res);
      }
    }
  );
};

const removeFromCart = (id) => {
  $.get("process/removeFromCartProcess.php?id=" + id, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      window.location.reload();
    } else if (response.status == "faild") {
      alert(response.message);
    } else if (response.status == "log") {
      alert(response.message);
      window.location = "index.php";
    } else {
      alert(res);
    }
  });
};

var productId = "";
var quantity = 0;
const buyitNow = (id) => {
  quantity = $("#qtyInput").val();
  $.get("process/buyitNowProcess.php?id=" + id + "&qty=" + quantity, (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      productId = id;
      proceedPayment(response.data);
    } else if (response.status == "faild") {
      alert(response.message);
    } else if (response.status == "log") {
      alert(response.message);
      window.location = "index.php";
    } else {
      alert(res);
    }
  });
};

const checkout = () => {
  $.get("process/checkoutProcess.php", (res) => {
    let response = JSON.parse(res);
    if (response.status == "success") {
      proceedPayment(response.data);
    } else if (response.status == "faild") {
      alert(response.message);
    } else if (response.status == "log") {
      alert(response.message);
      window.location = "index.php";
    } else {
      alert(res);
    }
  });
};

const proceedPayment = (data) => {
  // Payment completed. It can be a successful failure.
  payhere.onCompleted = function onCompleted(orderId) {
    alert("Payment completed. OrderID:" + orderId);
    saveInvoice(orderId);
  };

  // Payment window closed
  payhere.onDismissed = function onDismissed() {
    alert("Payment dismissed");
  };

  // Error occurred
  payhere.onError = function onError(error) {
    alert("Error:" + error);
  };

  payhere.startPayment(data);
};

const saveInvoice = (orderId) => {
  let form = new FormData();
  form.append("order_id", orderId);
  form.append("product_id", productId);
  form.append("quantity", quantity);

  $.ajax({
    url: "process/saveInvoiceProcess.php",
    type: "POST",
    data: form,
    contentType: false,
    processData: false,
    success: (res) => {
      let response = JSON.parse(res);
      if (response.status == "success") {
        window.location = "invoice.php?inv=INV-" + orderId;
      } else {
        alert(response.message);
      }

      //redirrect to invoice page on success
    },
  });
};

$("#print-invoice").click(() => {
  let bodyContent = $("body").html();
  $("body").html($("#invoice").html());
  window.print();
  $("body").html(bodyContent);
  window.location.reload();
});

function spinner(id,state){
  if(state == "ON"){
$("#"+id).addClass("active");
  }else if(state == "OFF"){
$("#"+id).removeClass("active");
  }  
}

$("#email-invoice").click(() => {
  $("#email-invoice-icon").addClass("d-none");
  spinner("email-invoice-spinner","ON");

  let form = new FormData();
  form.append("invoice", $('#email-invoice-content').html());

  $.ajax({
    url: "process/emailInvoiceProcess.php",
    type: "POST",
    data: form,
    contentType: false,
    processData: false,
    success: (res) => {
      $("#email-invoice-icon").removeClass("d-none");
      spinner("email-invoice-spinner","OFF");
      let response = JSON.parse(res);
      if (response.status == "success") {
        
        alert(response.message);
        window.location = "myOrders.php";
      } else {
        alert(response.message);
      }
    },
  });
});

$(".menu .item").tab();

$(document).ready(() => {
  $("#review-text").keyup(function () {
    $("#review-limit").text($(this).val().length);
    if ($(this).val().length >= 500) {
      $(this).addClass("is-invalid");
      $("#submit-review").addClass("disabled");
    } else {
      $(this).removeClass("is-invalid");
      $("#submit-review").removeClass("disabled");
    }
  });
});

const addReview = (id,invoice_item_id) => {
  let form = new FormData();
  form.append("pid", id);
  if(invoice_item_id != null){
    form.append("inv_item_id", invoice_item_id);
  }
  
  form.append("rate", $("#userRating").rating("get rating"));
  form.append("review", $("#review-text").val());


  $.ajax({
    url: "process/addReviewProcess.php",
    type: "POST",
    data: form,
    contentType: false,
    processData: false,
    success: (res) => {
      let response = JSON.parse(res);
      if (response.status == "success") {
        alert(response.message);
        window.location.reload();
      } else {
        alert(response.message);
      }
    },
  });
};

const openMessage = ()=>{
 
  new bootstrap.Modal($('#chat-modal')).show();
  loadMessages(); 
  setInterval(loadMessages, 1000);
;
};
const closeModal = ()=>{
 
  $('#chat-modal').modal('hide');
  clearInterval(loadMessages);
};


$(document).ready(() => {
  $("#send-btn").addClass("disabled");
  $("#message-text").keyup(function () {
    let textLength = $(this).val().trim().length;
    $("#message-limit").text(textLength);
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
          $("#message-limit").text("0");
          loadMessages();
         
        } else {
          alert(response.message);
        }
      },
    });
  });
});

const loadMessages=()=>{
  $.get(
    "process/loadMessagesProcess.php",
    (res)=>{
      $("#message-block").html(res);
      scrollMessageModal();
      updateSeenStatus();
    },
  );
};

const scrollMessageModal = ()=>{ 
   let scroll = document.getElementById("message-scroll");
   $(scroll).css("scroll-behavior","smooth");
   scroll.scrollTo(0,scroll.scrollHeight);

};

// load header unread messages count notifications functionality 
$(document).ready(()=>{
  reloadMessages();
});
const reloadMessages = ()=>{
  setInterval(loadMessageCount,500);
};

const loadMessageCount = ()=>{
  $.get(
    "process/loadMessageCountProcess.php",
    (res)=>{
      // alert(res);
      let response = JSON.parse(res);
      $("#unread-message-count").text(response.data);
    },
  );
};


//update message seen status functionality
function updateSeenStatus(){
  $.get("process/updateSeenStatusProcess.php");      
}

//cancel order functionality
function cancelOrder(invoice_id){
  if(confirm("Press OK to confirm your order cancellation")){
     $.get(
    "process/cancelOrderProcess.php?id="+invoice_id,
    (res)=>{
      let response = JSON.parse(res);
      if(response.status == "success"){
        window.location.reload();
      }else{
        alert(response.message);
      }
    },
  );
  }
 
}

//order modal functionality
var orderModal ;
function openOrderModal(invoice_id){
  orderModal = new bootstrap.Modal(document.getElementById("order-modal"+invoice_id));
  orderModal.show();
}
function openReceiveOrderModal(invoice_id){
  orderModal = new bootstrap.Modal(document.getElementById("receive-order-modal"+invoice_id));
  orderModal.show();
}

//review modal functionality
var reviewModal ;
var review_product_id;
var review_invoice_item_id;
function openReviewModal(product_id,title,invoice_item_id){
  review_product_id = product_id;
  review_invoice_item_id = invoice_item_id;
  reviewModal = new bootstrap.Modal(document.getElementById('review-modal'));
  $("#modal-title").append(title);
  $("#modal-image").attr('src',document.getElementById("image"+product_id).src);
  reviewModal.show();

}

function updateReviewStatus(invoice_item_id){
  $.get("process/updateReviewStatusProcess.php?id="+invoice_item_id,
  (res)=>{
    console.log(res);
    window.location.reload();
  });
}

function loadAddReview(){
  addReview(review_product_id,review_invoice_item_id);
  updateReviewStatus(review_invoice_item_id);
}

//load review history
function loadReviewHistory(page_no,reviews_per_page){
  $.get("process/loadReviewHistoryProcess.php?page="+page_no+"&reviewsPerPage="+reviews_per_page,
  (res)=>{
    $("#review-history-content").html(res);
  },
  );
}

// 
function loadCheckReviewModal(product_id,page){
  $.get("admin/process/loadCheckReviewProcess.php?id="+product_id+"&page="+page,
  (res)=>{
    $("#product-reviews-container").html(res);
  }
  )
}

// searchAdvanced
function searchAdvanced(){
  let key = document.getElementById("keyword").value;
  let cat = document.getElementById("category-id").value;
  let price_sort = 0;
  let max_price = 0;
  let min_price = 0;
  let cond = 0;
  let no_of_results = document.getElementById("no-of-results").value;

  if(document.getElementById("price1").checked){
    price_sort = "ASC";
  }
  if(document.getElementById("price2").checked){
    price_sort = "DESC";
  }
  if(document.getElementById("price3").checked){
    max_price = document.getElementById("price-max").value;
    min_price = document.getElementById("price-min").value;
    price_sort = "range";
  }

  if(document.getElementById("cond1").checked){
    cond = "Brand New";
  }
  if(document.getElementById("cond2").checked){
    cond = "Used";
  }
  if(document.getElementById("cond3").checked){
    cond = "Unbranded";
  }

  window.location = "advancedSearchProducts.php?key="+key+"&cat="+cat+"&price_sort="
  +price_sort+"&max_price="+max_price+"&min_price="+min_price+"&cond="+cond+"&no_of_results="+no_of_results;
}

function toggleActivePriceFilter(cond) {
  if(cond == 3){
    document.getElementById("price-min").disabled = false;
    document.getElementById("price-max").disabled = false;
  }else{
    document.getElementById("price-min").disabled = true;
    document.getElementById("price-max").disabled = true;
  }
 
}

function advancedSearchPaginationTransition(key,cat,price_sort,max_price,min_price,cond,no_of_results,page_no){
  window.location.href= "advancedSearchProducts.php?key="+key+"&cat="+cat+"&price_sort="
  +price_sort+"&max_price="+max_price+"&min_price="+min_price+"&cond="+cond+"&no_of_results="+no_of_results+"&page="+page_no;  
}

function changeResultsPerPage(key,cat,price_sort,max_price,min_price,cond,page_no){
  let no_of_results = document.getElementById("results-per-page").value;
  window.location.href= "advancedSearchProducts.php?key="+key+"&cat="+cat+"&price_sort="
  +price_sort+"&max_price="+max_price+"&min_price="+min_price+"&cond="+cond+"&no_of_results="+no_of_results+"&page="+page_no;  
}

function changeResultsPerPageGeneral(cat,key,cond,price,sort,page) {  
  let results_per_page = document.getElementById("results-per-page").value;
  window.location.href = "?cat="+cat+"&key="+key+"&cond="+cond+"&price="+price+"&sort="+sort+"&no_of_results="+results_per_page+"&page="+page;
}

function searchPaginationTransitionGeneral(cat,key,cond,price,sort,no_of_results,page){
  window.location.href = "?cat="+cat+"&key="+key+"&cond="+cond+"&price="+price+"&sort="+sort+"&no_of_results="+no_of_results+"&page="+page;
}

function filterConditionAdvancedSearch(key,cat,price_sort,max_price,min_price,cond,no_of_results,page){
  let condition = document.getElementById("condition-select").value;
  window.location.href = "?key="+key+"&cat="+cat+"&price_sort="+price_sort+"&max_price="+max_price+"&min_price="
  +min_price+"&cond="+condition+"&no_of_results="+no_of_results+"&page="+page;
}
function filterPriceAdvancedSearch(key,cat,price_sort,max_price,min_price,cond,no_of_results,page){
  let condition = document.getElementById("price-range-select").value;
  window.location.href = "?key="+key+"&cat="+cat+"&price_sort="+price_sort+"&max_price="+max_price+"&min_price="
  +min_price+"&cond="+cond+"&no_of_results="+no_of_results+"&page="+page;
}
function filterOrderAdvancedSearch(key,cat,price_sort,max_price,min_price,cond,no_of_results,page){
  let condition = document.getElementById("order-select").value;
  window.location.href = "?key="+key+"&cat="+cat+"&price_sort="+price_sort+"&max_price="+max_price+"&min_price="
  +min_price+"&cond="+condition+"&no_of_results="+no_of_results+"&page="+page;
}

$('.invoiceTarget')
  .popup()
;


