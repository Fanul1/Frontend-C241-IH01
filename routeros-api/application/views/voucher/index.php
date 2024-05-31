<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .box {
            margin: 10px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .box-group {
            display: flex;
            align-items: center;
            justify-content: left;
        }
        .box-group-icon {
            margin-right: 10px; /* Adjust this value to reduce spacing */
        }
        .box-group-icon a {
            font-size: 1.5em;
            color: #000;
        }
        .box-group-area h3 {
            margin: 0;
            color: #000;
        }
        .box-group-area a {
            color: #000;
            text-decoration: none;
        }
        .pointer {
            cursor: pointer;
        }
    </style>
    <title>Voucher</title>
</head>
<body>
<div class="content-wrapper mt-5">
    <div class="content-header">
        <div class="container-fluid">
            <h3>Voucher</h3>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="fa fa-users"></i> Vouchers &nbsp;&nbsp; | &nbsp;&nbsp;
                    <i onclick="location.reload();" class="fa fa-refresh pointer" title="Reload data"></i>
                </h3>
            </div>
            <div class="card-body">
                <div class="overflow" style="max-height: 80vh">
                    <div class="row">
                        <?php foreach ($profiles as $profile): ?>
                            <div class="col-4">
                                <div class="box" style="background-color: <?= $profile['name'] == 'default' ? 'yellow' : 'purple'; ?>">
                                    <div class="box-group">
                                        <div class="box-group-icon">
                                            <a title="Open User by profile <?= $profile['name'] ?>" href="./?hotspot=users&profile=<?= urlencode($profile['name']) ?>">
                                                <i class="fa fa-ticket"></i>
                                            </a>
                                        </div>
                                        <div class="box-group-area">
                                            <h3>Profile: <?= $profile['name'] ?><br>
                                                <?= $profile['user_count'] ?> Items
                                            </h3>
                                            <a title="Open User by profile <?= $profile['name'] ?>" href="./?hotspot=users&profile=<?= urlencode($profile['name']) ?>">
                                                <i class="fa fa-external-link"></i> Open
                                            </a>&nbsp;
                                            <a title="Generate User by profile <?= $profile['name'] ?>" href="<?= site_url('voucher/generate')?>">
                                                <i class="fa fa-users"></i> Generate
                                            </a>&nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
