<div class="row w-100">
    <div class="col-12">
        <div class="title-primary">Số lượng bài viết</div>
    </div>
    <div class="col-3 col-xs-2">
        <div class="card card--shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div class="count">
                    <h4 class="fw-600">{{$today ?? 0}}</h4>
                    <h5>Hôm nay</h5>
                </div>
                <div class="dash-imgs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 col-xs-2">
        <div class="card card--shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div class="count">
                    <h4 class="fw-600">{{$yesterday ?? 0}}</h4>
                    <h5>Hôm qua</h5>
                </div>
                <div class="dash-imgs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 col-xs-2">
        <div class="card card--shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div class="count">
                    <h4 class="fw-600">{{$month ?? 0}}</h4>
                    <h5>Tháng này</h5>
                </div>
                <div class="dash-imgs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 col-xs-2">
        <div class="card card--shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div class="count">
                    <h4 class="fw-600">{{$total ?? 0}}</h4>
                    <h5>Tổng</h5>
                </div>
                <div class="dash-imgs">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
            </div>
        </div>
    </div>
</div>