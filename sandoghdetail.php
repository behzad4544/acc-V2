<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/bootstrap5.min.css">
    <script src="./JS/bootstrap5.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="product">
    
  <div class="d-flex" id="wrapper">

        <!-- sidebar starts here -->

        <!-- sidebar ends here -->

        <?php
        require_once "./template/sidebar.php";
        require_once "./template/header.php";
        ?>
        <div class="purchasecontainerpeople">
          <div class="container-fluid invoice-container">
            
         <main>   
             <header>
                      <div class=" userlist">
                          <h2> جزییات کاردکس بانک ملت  </h2>
                     </div>
                 
               </header>
                <div class="row">
                  <div class="text-end" style="margin-bottom: 15px ;"> <strong> مانده کل بانک ملت : </strong> 53300000</div>
                
                      <div class="card">
                             <div class="card-body p-0">
                                  <div class="table-responsive usertable">
                                      <table class="table mb-0">
                                          <thead class="card-header">
                                               <tr>
                                                    <td class="col-3 text-center"><strong> وضعیت کلی </strong></td>
                                                    <td class="col-3 text-center"><strong>مانده </strong></td>
                                                    <td class="col-3 text-center"><strong> مبلغ بستانکاری </strong></td>
                                                    <td class="col-3 text-center"><strong> مبلغ بدهکاری</strong></td>
                                                    <td class="col-3 text-center"><strong> شماره سند </strong></td>
                                                    <td class="col-3 text-center"><strong> تاریخ </strong></td>
                                                    <td class="col-3 text-center"><strong>ردیف</strong></td>
                                                    
                                              </tr>
                                         </thead>
                                       

                                         <tbody>
                                              <tr>
                                                 <td class="col-3 text-center"><strong> بدهکار </strong></td>
                                                 <td class="col-3 text-center"><strong> 100 </strong></td>
                                                 <td class="col-3 text-center"><strong> 100 </strong></td>
                                                 <td class="col-3 text-center"><strong> 200 </strong></td>
                                                 <td class="col-3 text-center"><strong> 24 </strong></td>
                                                 <td class="col-3 text-center"><strong> 1402/02/03</strong></td>
                                                 <td class="col-3 text-center"><strong> 1 </strong></td>
                                              </tr>
                                         </tbody>

                                         <tbody>
                                              <tr>
                                                 <td class="col-3 text-center"><strong> بستانکار </strong></td>
                                                 <td class="col-3 text-center"><strong> 130 </strong></td>
                                                 <td class="col-3 text-center"><strong> 20 </strong></td>
                                                 <td class="col-3 text-center"><strong>  50 </strong></td>
                                                 <td class="col-3 text-center"><strong> 32 </strong></td>
                                                 <td class="col-3 text-center"> <strong> 1402/02/20</strong></td>
                                                 <td class="col-3 text-center"><strong> 2 </strong></td>
                                              </tr>
                                         </tbody>

                                         <tbody>
                                              <tr>
                                                 <td class="col-3 text-center"><strong> بستانکار  </strong></td>
                                                 <td class="col-3 text-center"><strong> 100 </strong></td>
                                                 <td class="col-3 text-center"><strong> 50 </strong></td>
                                                 <td class="col-3 text-center"><strong>  20 </strong></td>
                                                 <td class="col-3 text-center"><strong> 45 </strong></td>
                                                 <td class="col-3 text-center"><strong>1402/03/01 </strong></td>
                                                 <td class="col-3 text-center"><strong> 3 </strong></td>
                                              </tr>
                                         </tbody>

                                         <tbody>
                                              <tr>
                                                 <td class="col-3 text-center"><strong> بدهکار  </strong></td>
                                                 <td class="col-3 text-center"><strong> 100 </strong></td>
                                                 <td class="col-3 text-center"><strong> 50 </strong></td>
                                                 <td class="col-3 text-center"><strong>  20 </strong></td>
                                                 <td class="col-3 text-center"><strong> 45 </strong></td>
                                                 <td class="col-3 text-center"><strong>1402/03/01 </strong></td>
                                                 <td class="col-3 text-center"><strong> 4 </strong></td>
                                              </tr>
                                         </tbody>

                                         <tbody>
                                              <tr>
                                                 <td class="col-3 text-center"><strong> بدهکار  </strong></td>
                                                 <td class="col-3 text-center"><strong> 100 </strong></td>
                                                 <td class="col-3 text-center"><strong> 50 </strong></td>
                                                 <td class="col-3 text-center"><strong>  20 </strong></td>
                                                 <td class="col-3 text-center"><strong> 45 </strong></td>
                                                 <td class="col-3 text-center"><strong>1402/03/01 </strong></td>
                                                 <td class="col-3 text-center"><strong> 5 </strong></td>
                                              </tr>
                                         </tbody>

                                        
                                     </table>
                                 </div>
                             
                      </div> 
                   </div>
                 </div>
         </main>

        
         
            <footer class="text-center mt-4 ">
              <div class="btn-group btn-group-sm footer ">
                   <a href="javascript:window.print()" class="btn btn-light border"><ion-icon name="print-outline"></ion-icon> پرینت </a>
                   <a href="javascript:window.print()" class="btn btn-light border"><ion-icon name="download-outline"></ion-icon> دانلود</a>
             </div>
         </footer>
     </div>
 </div>
 


  <script>
    var el = document.getElementById("wrapper")
    var toggleButton = document.getElementById("menu-toggle")

    toggleButton.onclick = function() {
        el.classList.toggle("toggled")
    }
 </script>

</body>























