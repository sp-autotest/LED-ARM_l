<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-inverse">

                <div class="panel-heading">
                    <h3 class="panel-title">Добавить расписание</h3>
                </div>
                <!-- /.panel-header -->
                <div class="panel-body">

                    <div class="container spark-screen">
                        <div class="row">
                            <div class="col-lg-10 col-md-offset-1">

                            </div>
                        </div>
                        2312121321
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
#search-crane-container .radio {
  display: inline-block;
  position: relative;
  cursor: pointer;
  
}

#search-crane-container .radio input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
.searchbtn {
    background: #5CDF81;
    border-radius: 4px;
    font-family: Montserrat;
    font-style: normal;
    font-weight: bold;
    font-size: 12px;
    line-height: normal;
    text-align: center;
    text-transform: uppercase;

    color: #FFFFFF;
}
.checkmark {
  position: absolute;
  top: 5px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}
#search-crane-container .radio.radio-css.radio-inline {
    padding-left: 27px;
}
.radio:hover input ~ .checkmark {
  background-color: #ccc;
}
.radio.radio-css label {padding:0;}
#search-crane-container .radio.radio-css input:checked+label {padding-left: 0px; background: #00F581;}
#search-crane-container .radio.radio-css label:before {}

#search-crane-container .radio.radio-css input:checked+label:before {
background-color:#00F581;
}
.radio.radio-css label:before {
    content: '';
    position: absolute;
    left: 2px;
    top: 2px;
    width: 16px;
    height: 16px;
    border-radius: 16px;
    background: #dee2e6;
}
.radio input:checked ~ .checkmark div {
  position: absolute;
  background-color:#00F581;
  height:12px;
  width:12px;
  top:4px;
  left:4px;
  z-index:1;
  border-radius:50%;
}
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}
.radio input:checked ~ .checkmark:after {
  display: block;
}
.radio .checkmark:after {
    top: 1px;
    left: 1px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: white;
}
#search-crane-container .radio.radio-css input:checked+label:after {
        z-index: 1;
        background-color:#00F581;
        top:5px;
        left:5px;
        border-radius: 50%;
        width: 10px;
        height: 10px;
}
#search-crane-container input:checked ~ .checkmark .checkedadd {
  position: absolute;
  background-color:#fff;
  height:16px;
  width:16px;
  top:2px;
  left:2px;
  z-index:1;
  border-radius:50%;
}
#search-crane-container .switcher label:before {
    width: 37px;
    height: 20px;
}
#search-crane-container .switcher label:after {
    height: 15px;
    width: 15px;
}
#search-crane-container .switcher label {
    height: 20px;
}
#search-crane-container .switcher input:checked+label:before {
    background-color:#00F581;
    border-color:#00F581;
}
</style>
