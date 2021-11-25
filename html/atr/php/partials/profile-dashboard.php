<?php

namespace partials;

function profile_dashboard()
{

?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">ダッシュボード</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">共有</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">出力</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            今週
        </button>
        </div>
    </div>
<?php
}
