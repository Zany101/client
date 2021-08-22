// Get States By Country ID

//
// $(document).ready(function(){
//     $('#country').on('change', function(){
//         var search = $(this).val();
//         if(countryID){
//             $.ajax({
//                 type:'POST',
//                 url:'/templates/script/ajax/product_filter.php',
//                 data:'search='+search,
//                 success:function(html){
//                     $('#state').html(html);
//                     $('#city').html('<option value="">Select state first</option>');
//                 }
//             });
//         }else{
//             $('#state').html('<option value="">Select country first</option>');
//         }
//     });
// });

// // Handle Currency
// $(document).ready(function(){
//   $('#quantity').add('#plan').on('change', function()  {
//     // USD = 80 EUR = 76
//     var delay = 2000;
//       var plan = $('#plan').val();
//       var quantity = $('#quantity').val();
//       var item = $('#item').val();
//         $.ajax({
//             type:'POST',
//             data: {
//               quantity:quantity,
//               item:item,
//               plan:plan,
//               currency_handle:true,
//             },
//             beforeSend: function() {
//                 $("#loaderDiv").show();
//                 $('#price').html("<div class=\"d-flex justify-content-center\">" +
//                   "<div id=\"loaderDiv\" class=\"spinner-border\" role=\"status\" style=\"display: show;\">" +
//                   "<span class=\"sr-only\">Loading...</span>" +
//                   "</div>" + "</div>"
//                 );
//             },
//             complete: function(){
//                $('#loader').hide();
//             },
//             success:function(html){
//               setTimeout(function(){
//                 $('#price').html(html);
//               }, delay);
//             }
//         });
//   });
// });

// });
