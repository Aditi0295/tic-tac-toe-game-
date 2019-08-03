$(document).ready(function(){

	$("#start_survey").on("click",function(e){
		console.log("here");
		$(".welcome_sec").hide();
	});

	$(".que_pallet_num").on("click",function(e){
		var qcn=this.dataset.queId;
		console.log(qcn);
		$(this).manager({
			url:"server/manager.php",
			data: {
				qid:qcn,
				action:'fetch_current'
			},
			callbackfunc:function(data){
				console.log(data);
				data=JSON.parse(data);
				fitcircle.que_cnt=qcn;
				changeQuestion(data);
			}
		});
	});

	$('#prev').on('click',function(e){
		if(fitcircle.que_cnt>0){

		}
	});

	$("#next").on("click",function(e){
		if(fitcircle.que_cnt<fitcircle.total){
			var qcn=this.dataset.queId;
			console.log(qcn);

			if(!$('#optA').prop('checked')&&
				!$('#optB').prop('checked')&&
				!$('#optC').prop('checked')&&
				!$('#optD').prop('checked')){
				console.log('here 2');
				if(fitcircle.first_miss==0){
					fitcircle.first_miss=parseInt(this.dataset.queId);
				}
			}
			else{
				$(".que_pallet_num").eq(parseInt(qcn)-1).toggleClass('chk_green');
				fitcircle.attempt++;
			}
			
			$(this).manager({
				url:"server/manager.php",
				data: {
					qid:qcn,
					action:'fetch'
				},
				callbackfunc:function(data){
					console.log(data);
					data=JSON.parse(data);
					fitcircle.que_cnt++;
								
					changeQuestion(data);
				}
			});
		}
		else{
			if(fitcircle.first_miss>0){
				alert('Attempt All Questions');
			}
			else{
				alert('Thank You For Taking Survey');
			}
		}
	});

	var changeQuestion=function(data){
		$('#survey_question').text('Q'+data['data']['id']+' '+data['data']['que_txt']);
		$('#survey_opt_a').text(data['data']['opt_a']);
		$('#survey_opt_b').text(data['data']['opt_b']);
		$('#survey_opt_c').text(data['data']['opt_c']);
		$('#survey_opt_d').text(data['data']['opt_d']);

		$('#optA').prop('checked',false);
		$('#optB').prop('checked',false);
		$('#optC').prop('checked',false);
		$('#optD').prop('checked',false);

		$('#prev').attr({'data-que-id':parseInt(data['data']['id'])-1});
		$('#next').attr({'data-que-id':data['data']['id']});
	}

	$("#searchForm").on("submit",function(e){
		e.preventDefault();

		var query=this.search.value;

		$('.card_cont>*').detach();

		
	});
});