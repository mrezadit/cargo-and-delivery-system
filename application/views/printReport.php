<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>Report Shipment</title>
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap"
			rel="stylesheet"
		/>
		<style>
			@media print {
				@page {
					size: A3;
				}
			}
			ul {
				padding: 0;
				margin: 0 0 1rem 0;
				list-style: none;
			}
			body {
				font-family: "Inter", sans-serif;
				margin: 0;
			}
			table {
				width: 100%;
				border-collapse: collapse;
			}
			table,
			table th,
			table td {
				border: 1px solid silver;
			}
			table th,
			table td {
				text-align: right;
				padding: 8px;
			}
			h1,
			h4,
			p {
				margin: 0;
			}

			.container {
				padding: 20px 0;
				width: 1000px;
				max-width: 90%;
				margin: 0 auto;
			}

			.inv-title {
				padding: 10px;
				border: 1px solid silver;
				text-align: center;
				margin-bottom: 30px;
			}

			.inv-logo {
				width: 150px;
				display: block;
				margin: 0 auto;
				margin-bottom: 40px;
			}

			/* header */
			.inv-header {
				display: flex;
				margin-bottom: 20px;
			}
			.inv-header > :nth-child(1) {
				flex: 2;
			}
			.inv-header > :nth-child(2) {
				flex: 1;
			}
			.inv-header h1 {
                padding-top:20px;
                padding-bottom:10px;
				font-size: 20px;
				margin: 0 0 0.3rem 0;
			}
			.inv-header ul li {
				font-size: 15px;
				padding: 3px 0;
			}

			/* body */
			.inv-body table th,
			.inv-body table td {
				text-align: left;
			}
			.inv-body {
				margin-bottom: 30px;
			}

			/* footer */
			.inv-footer {
				display: flex;
				flex-direction: row;
			}
			.inv-footer > :nth-child(1) {
				flex: 2;
			}
			.inv-footer > :nth-child(2) {
				flex: 1;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="inv-header">
				<div>
                    <h1><b>Cargo and Delivery system</b></h1>
					<h1><b>Report Shipment Status</b></h1>
                    <ul>
                    <li>Scheduled on <?= date('d-m-Y',strtotime ($capacity['schedule']));?></li>
                    </ul>
                    <ul>
						<li><span class="mb-3 text-sm">Driver : <b><?= $capacity['driver']?>  </b></span></li>
						<li><span class="mb-3 text-sm">Phone : <b><?= $capacity['phone']?>  </b></span></li>
					</ul>
				</div>
				<div>
					<table>
						<tr>
							<th>Truck </th>
							<td><?= $capacity['truck']?></td>
						</tr>
						<tr>
                            <th>No Plat </th>
							<td><?= $capacity['no_plate']?></td>
						</tr>
						<tr>
							<th>Berat </th>
							<td><?= $capacity['b_capacity']?> kg / <?= $capacity['bmax']?> kg</td>
						</tr>
						<tr>
							<th>Volume </th>
							<td><?= substr($capacity['r_capacity'], 0, 4)?> m&sup3 / <?= $capacity['capacity']?> m&sup3</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="inv-body">
				<table>
					<thead>
						<th>No</th>
						<th>Package</th>
						<th>Route Point</th>
                        <th>Volume</th>
						<th>Status</th>
					</thead>
					<tbody>
                    <?php if (!empty($package)) : $i = 1; foreach (array_reverse($package) as $value) : ?>
                        <tr>
                        <td>
                        <div class="d-flex pl-3">
                            <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?= $i++; ?> </h6>
                            </div>
                        </div>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"> <?= $value->no_package; ?> - <?= $value->customer_name; ?> </span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->kota; ?> - <?= $value->address; ?></span> </br>
                        </td>
                        <td class="pl-4">
                            <span class="text-sm font-weight-bold"><?= $value->t_kg ?> kg - <?= $value->t_kgv ?> m&sup3 </span> </br>
                        </td>
                        <td class="pl-4">
                        <?php if ( $value->pstatus == 3) : ?>
                        <span class="text-xs font-weight-bold text-warning">Returned</span>
                        <?php elseif ( $value->pstatus == 4) : ?>
                        <span class="text-xs font-weight-bold text-success">Received</span>
                        </td>
						<?php else : ?>
                        <span class="text-xs font-weight-bold text-success">Processed</span>
                        </td>
                        <?php endif ;?> 
                        </tr>
                        <?php endforeach; endif; ?>
                        
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>