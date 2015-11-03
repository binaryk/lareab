; var Dosarchizitii = function(properties)
{
	for( property in properties )
	{
		this[property] = properties[property];
	}

	this.vm = new Vue({
		el   : '#dosar-achizitii-container',
		data : 
		{
			tip : 'achizitor',

			texts : {
				caption : {
					achizitor : 'Dosar achizitii achizitor',
					ofertant  : 'Dosar achizitii ofertant'
				},
				action : {
					add   : 'Adaugare document',
					edit  : 'Editare document',
					del   : 'Stergere document',
				}
			},

			records : {
				achizitor : this.documente_achizitor,
				ofertant  : this.documente_ofertant,
			},

			id_template_achizitii : this.template_achizitii.id,

			clasificare_documente : this.clasificare_documente,
			mod_solicitare        : this.mod_solicitare,
			mod_predare           : this.mod_predare,

			endpoints             : this.endpoints,

			currentRecord : null,
			currentAction : 'add',

			fieldsErrors : null,
		},

		methods :
		{
			caption : function(tip)
			{
				return this.texts.caption[tip];
			},

			actionTitle : function()
			{
				return this.texts.action[this.currentAction];
			},

			changeTip : function(tip)
			{
				this.tip           = tip;
				this.setEmptyRecord();
			},

			changeCurrentRecord : function(record, action)
			{
				this.currentAction = action;
				this.currentRecord = record;
			},

			clasificareDocumente : function()
			{
				var result = [{text: '- Selectati clasificare documente -', value: 0 }];
				for(i = 0; i < this.clasificare_documente.length; i++)
				{
					result.push({text: this.clasificare_documente[i].nume, value:this.clasificare_documente[i].id});
				}
				return result;
			},

			modSolicitare : function()
			{
				var result = [{text: '- Selectati modul de solicitare -', value: 0 }];
				for(field in this.mod_solicitare)
				{
					result.push({text: this.mod_solicitare[field], value:field});
				}
				return result;
			},

			modPredare : function()
			{
				var result = [{text: '- Selectati modul de predare -', value: 0 }];
				for(field in this.mod_predare)
				{
					result.push({text: this.mod_predare[field], value:field});
				}
				return result;
			},

			numarOrdine : function()
			{
				var result = 0;
				for(i = 0; i < this.records[this.tip].length; i++)
				{
					if(this.records[this.tip][i].numar_ordine > result)
					{
						result = this.records[this.tip][i].numar_ordine;
					}
				}
				return 1 + parseInt(result);
			},


			setEmptyRecord : function()
			{
				this.currentRecord = {
					id                       : null,
					numar_ordine             : this.numarOrdine(),
					document_necesar         : '',
					observatii               : '',
					id_clasificare_documente : '0',
					mod_solicitare           : '0',
					mod_predare              : '0'
				};
			},

			showForm : function(action, record)
			{
				this.currentAction = action;
				if( action == 'add')
				{
					this.setEmptyRecord();
				}
			},

			getData : function()
			{
				var result = this.currentRecord;
				result['id_template_achizitii'] = this.id_template_achizitii;
				result['tip_dosar'] = this.tip;
				return result;
			},

			addNewRecord : function()
			{

				this.$http.post(this.endpoints['insert'], this.getData() )
					.success(function(response){
						if(response.success)
						{
							this.records[this.tip].push({
								id                       : response.id,
								numar_ordine             : this.currentRecord.numar_ordine,
								document_necesar         : this.currentRecord.document_necesar,
								observatii               : this.currentRecord.observatii,
								id_clasificare_documente : this.currentRecord.id_clasificare_documente,
								mod_solicitare           : this.currentRecord.mod_solicitare,
								mod_predare              : this.currentRecord.mod_predare
							});
							this.fieldsErrors = null;
							this.setEmptyRecord();
						}
						else
						{
							if(response['validation-fail'])
							{
								this.fieldsErrors = response.messages;
							}
						}
					})
					.error(function(error){
						console.log('Error', error);
					})
					.always(function(response){
					});
			},

			editRecord : function()
			{
				this.$http.post(this.endpoints['update'], this.getData() )
					.success(function(response){
						if(response.success)
						{
							this.fieldsErrors = null;
						}
						else
						{
							if(response['validation-fail'])
							{
								this.fieldsErrors = response.messages;
							}
						}
					})
					.error(function(error){
						console.log('Error', error);
					})
					.always(function(response){
					});
			},

			delRecord : function()
			{
				this.$http.post(this.endpoints['delete'], this.getData() )
					.success(function(response){
						if(response.success)
						{
							console.log(response);
							this.fieldsErrors = null;
							console.log(this.records[this.tip]);
							console.log(this.currentRecord.document_necesar);
							this.records[this.tip].$remove(this.currentRecord);
						}
						else
						{
							if(response['validation-fail'])
							{
								this.fieldsErrors = response.messages;
							}
						}
					})
					.error(function(error){
						console.log('!!ERR!!', error);
					})
					.always(function(response){
					});
			}
		} 
	});

	this.vm.setEmptyRecord();

	$('#dosar-achizitii-container').on('mouseenter', '.list-group-item', 
		function()
		{
			$(this).find('.delete-record, .edit-record').show();
		}
		/*,
		function()
		{
			$(this).find('.delete-record, .edit-record').hide();
		}
		*/
	);

	$('#dosar-achizitii-container').on('mouseleave', '.list-group-item', 
		/*function()
		{
			$(this).find('.delete-record, .edit-record').show();
		},
		*/
		function()
		{
			$(this).find('.delete-record, .edit-record').hide();
		}
	);
}