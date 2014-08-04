<div style="background:#d93f3f;height:44px;position:relative;text-align:center;">
	<div style="font-size:18px;display:inline-block;line-height:44px;color:#fff;font-weight:bold;">
	大乐透开奖信息</div>
</div>
<div class="container-fluid">
	 
     <h3>
       <small>第<?php echo $detail['periodicalno']?>期<!-- （） -->：</small><br />
       <span style="color:red;"><?php echo $detail['foreresult'] ?></span>
       <span style="color:blue;"><?php echo $detail['backresult'] ?></span>
     </h3>
	 <div class="row">
	 	<table class="table">
	        <thead>
	        	<tr><th>奖项</th><th>中奖注数</th><th>每注奖金</th></tr>
	        </thead>
	        <tbody>
	        	<tr>
	        		<td>一等奖（基本）</td><td><?php echo number_format($detail['basenum1'])?></td><td><?php echo number_format($detail['basemoney1']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>一等奖（追加）</td><td><?php echo number_format($detail['additionnum1'])?></td><td><?php echo number_format($detail['additionmoney1']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>二等奖（基本）</td><td><?php echo number_format($detail['basenum2'])?></td><td><?php echo number_format($detail['basemoney2']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>二等奖（追加）</td><td><?php echo number_format($detail['additionnum2'])?></td><td><?php echo number_format($detail['additionmoney2']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>三等奖（基本）</td><td><?php echo number_format($detail['basenum3'])?></td><td><?php echo number_format($detail['basemoney3']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>三等奖（追加）</td><td><?php echo number_format($detail['additionnum3'])?></td><td><?php echo number_format($detail['additionmoney3']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>四等奖（基本）</td><td><?php echo number_format($detail['basenum4'])?></td><td><?php echo number_format($detail['basemoney4']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>四等奖（追加）</td><td><?php echo number_format($detail['additionnum4'])?></td><td><?php echo number_format($detail['additionmoney4']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>五等奖（基本）</td><td><?php echo number_format($detail['basenum5'])?></td><td><?php echo number_format($detail['basemoney5']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>五等奖（追加）</td><td><?php echo number_format($detail['additionnum5'])?></td><td><?php echo number_format($detail['additionmoney5']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>六等奖（基本）</td><td><?php echo number_format($detail['basenum6'])?></td><td><?php echo number_format($detail['basemoney6']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>六等奖（追加）</td><td><?php echo number_format($detail['additionnum6'])?></td><td><?php echo number_format($detail['additionmoney6']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>七等奖（基本）</td><td><?php echo number_format($detail['basenum7'])?></td><td><?php echo number_format($detail['basemoney7']) ?></td>
	        	</tr>
	        	<tr>
	        		<td>七等奖（追加）</td><td><?php echo number_format($detail['additionnum7'])?></td><td><?php echo number_format($detail['additionmoney7']) ?></td>
	        	</tr>
	        </tbody>
	    </table>
	 </div>
	 <div class="row">
	 	<h4 class="col-xs-12">提点</h4>
	 	<div class="col-xs-12">
	 		<?php 
	 			$info = json_decode($detail['info'], true);
	 			foreach ($info['tidian'] as $tidian){
	 		?>
	 		<small><?php echo $tidian ?></small><br />
			<?php 
				}
			?>
			
			<br />
	 	</div>
	 </div>
</div>