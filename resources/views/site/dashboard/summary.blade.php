<div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 row-cols-xxl-4">
    <div class="col-12 mb-2">
        <h4>Thống kê</h4>
    </div>
    <div class="col">
      <div class="card radius-10 bg-gradient-cosmic">
         <div class="card-body">
             <div class="d-flex align-items-center">
                 <div class="me-auto">
                     <p class="mb-0 text-dark">Số bài viết hôm nay</p>
                     <h4 class="my-1 text-dark">{{number_format($count_today)}}</h4>
                 </div>
             </div>
         </div>
      </div>
    </div>
    <div class="col">
     <div class="card radius-10 bg-gradient-ibiza">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <p class="mb-0 text-dark">Đã đồng bộ</p>
                    <h4 class="my-1 text-dark">{{number_format($count_synced)}}</h4>
                </div>
            </div>
        </div>
     </div>
   </div>
   <div class="col">
     <div class="card radius-10 bg-gradient-ohhappiness">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <p class="mb-0 text-dark">Số bài viết tháng này</p>
                    <h4 class="my-1 text-dark">{{number_format($count_month)}}</h4>
                </div>
            </div>
        </div>
     </div>
   </div>
   <div class="col">
     <div class="card radius-10 bg-gradient-kyoto">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <p class="mb-0 text-dark">Tổng số bài viết</p>
                    <h4 class="my-1 text-dark">{{number_format($count_total)}}</h4>
                </div>
            </div>
        </div>
     </div>
   </div> 
 </div>