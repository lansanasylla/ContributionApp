// TODO;
$(document).ready(function(){
    $(window).on('resize',function(){
    var winWidth =  $(window).width();
    if(winWidth < 768 ){
        document.getElementById('navTab').style.marginTop="105px";
    }else{
        document.getElementById('navTab').style.marginTop="70px";
    }
    });

    if($('[ng-controller="listController"]').scope().donneeFiltre.length < 10){
        $(".next").addClass('disabled');
    }

    $("#addfilter").on('click',function(e){
        e.preventDefault();
        $('#filterForm').css('display','block');
        $('#filteropt').change(function(){
            if($( "#filteropt option:selected" ).text() == "Date"){
                $('#filterType').css('display','block');
            }else{
                $('#filterType').css('display','none');
                $('.opt-1').text('Valeur');
                $('.opt-2').css('display','none');
                $( "#filterType-1" ).val("Valeur");
            }
        });
        
    });
    $(".next").on('click',function(e){
        e.preventDefault();
        if(!$(".next").hasClass('disabled')){
            if($(".previous").hasClass('disabled')){
                $(".previous").removeClass('disabled');
            }

            $('[ng-controller="listController"]').scope().current = $('[ng-controller="listController"]').scope().end+1;
            $('[ng-controller="listController"]').scope().start = $('[ng-controller="listController"]').scope().current;
            $('[ng-controller="listController"]').scope().currentPage += 1;  

            $('[ng-controller="listController"]').scope().setEnd(
                $('[ng-controller="listController"]').scope().current
            );  

            if($('[ng-controller="listController"]').scope().end == $('[ng-controller="listController"]').scope().donnee.length-1){
                $(".next").addClass('disabled');
            }

           //console.log($('[ng-controller="listController"]').scope().end); 

            $('[ng-controller="listController"]').scope().$apply();
        } 
    });
      $(".previous").on('click',function(e){
        e.preventDefault();
        if(!$(".previous").hasClass('disabled')){
            if($(".next").hasClass('disabled')){
                $(".next").removeClass('disabled');
            }

            $('[ng-controller="listController"]').scope().current = $('[ng-controller="listController"]').scope().current-10;
            $('[ng-controller="listController"]').scope().start = $('[ng-controller="listController"]').scope().current;
            $('[ng-controller="listController"]').scope().currentPage -= 1;  

            $('[ng-controller="listController"]').scope().setEnd(
                $('[ng-controller="listController"]').scope().current
            );  

            if($('[ng-controller="listController"]').scope().end == 9){
                $(".previous").addClass('disabled');
            }

            //console.log($('[ng-controller="listController"]').scope().end); 

            $('[ng-controller="listController"]').scope().$apply();
        } 
    });
    $('#filterType-1').change(function(){
        if($( "#filterType-1 option:selected" ).text() == "Intervalle"){
            $('.opt-1').text('Du');
            $('.opt-2').css('display','block');
        }else{
            $('.opt-1').text('Valeur');
            $('.opt-2').css('display','none');
        }
    });
    $("#newfilter").on('click',function(e){
        e.preventDefault();
        
    });
});

//
var donatorApp = angular.module('donatorApp', []);

// create donatorController


donatorApp
.controller('listController', ['$scope', '$window', '$filter', function($scope, $window, $filter) {
  $scope.donnee = $window.data;
  $scope.filtre = {First_Name:''};
  $scope.Math = $window.Math;
  $scope.startDate = ''
  $scope.endDate = ''
  $scope.start = 0;
  $scope.current = 0;
  $scope.currentPage = 0;

  $scope.rangeFilter = function(startDate,endDate,val) {
    if(startDate === "" && endDate === ""){
        return val;
    }
    if(val.Date_Contributors>=startDate && val.Date_Contributors<=endDate){
        return val;
    }
    return false;
  }

$scope.customFilter = function(){
    var data = $filter('filter')($scope.donnee, $scope.filtre);
    var don = [];
    data.map(function(val){
        if($scope.rangeFilter($scope.startDate,$scope.endDate,val) != false){
            don.push($scope.rangeFilter($scope.startDate,$scope.endDate,val));
        }
    });
    return don;
}

  $scope.donneeFiltre = $scope.customFilter();

  if($scope.donneeFiltre.length % 10 == 0){
     $scope.TotalPage = $scope.Math.trunc($scope.donneeFiltre.length / 10);
     if($scope.TotalPage > 0){
         $scope.currentPage = 1;
     }
  }else{
       $scope.TotalPage = $scope.Math.trunc((($scope.donneeFiltre.length) / 10) + 1);
       $scope.currentPage = 1;
  }

  $scope.setEnd = function(current){
      if((current + 10) > $scope.donneeFiltre.length-1){ 
        $scope.end = $scope.donneeFiltre.length-1;
        }else{
            $scope.end = current + 9;
        }
  }
  $scope.setEnd($scope.current);

  $scope.range = function(min, max,data) {
        var input = [];
        for (var i = min; i <= max; i ++) {
            input.push(data[i]);
        }
        return input;
    };

}])
.controller('donatorController', function($scope) {

    $scope.dat=new Date();         
   
})

// create listController
;