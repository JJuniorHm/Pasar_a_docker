<style type="text/css">

  .dns-ctner-card-md {
    padding: 12px;
    display: flex;
    justify-content: space-between;
  }

  .dns-card-md {
    background-color: #fff; 
    padding: 15px;
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
  }

	.dns-card-chartline-gs{ 
		background: #fff;
		padding: 15px;
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
	}
  .dns-card-chartline-gs h4{
    color: #25396f;
  }
  .dns-card-chartline-gs #gs-chartline-año{
    border:0px solid;
    border-bottom:2px solid #25396f;
    color: #25396f;
    font-weight: 500;
  }

  .dns-card-chartline-gs #gs-chartline-año option{
    color: #25396f;
    font-weight: 500;
  }

  .dns-card-chartline-gs #gs-chartline-mes{
    border:0px solid;
    border-bottom:2px solid #25396f;
    color: #25396f;
    font-weight: 500;
  }

  .dns-card-chartline-gs #gs-chartline-mes option{
    color: #25396f;
    font-weight: 500;
  }

	.splineChart {
    width: 100%;
    height: 250px;
	}

  .dns-ctndor-table {
    background: #fff;
    padding: 15px; 
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
    color: #25396f;
  }

  .dns-ctndor-table #btn_gctcrciaendas, #btn_gstcrciaendas{
    background-color: #fff;
    outline: none;
    border: none;
    color: #3a57e8;
    padding: 8px 15px;
    margin: 0 5px;
    font-weight: 500;
    transition: 0.3s;
  }

  .dns-ctndor-table #btn_gctcrciaendas:hover {
    background-color: #3a57e8;
    color: #fff;
    border-radius: 15px;
  }
  .dns-ctndor-table #btn_gstcrciaendas:hover {
    background-color: #3a57e8;
    color: #fff;
    border-radius: 15px;
  }

  .dns-ctndor-table #btn_gctcrciaendas.active{
    background-color: #3a57e8;
    color: #fff;
    border-radius: 15px;
  }

  .dns-ctndor-table #btn_gstcrciaendas.active{
    background-color: #3a57e8;
    color: #fff;
    border-radius: 15px;
  }

  .dns-ctndor-table .dns-table { 
    animation: fadeIn 0.6s ease-in-out;
  }

  .dns-ctndor-table .dns-table table {
    color: #25396f;
  }

  .dns-ctndor-table .dns-table.fadeOut { 
    animation: fadeOut 0.3s ease-in-out;
  }

  @keyframes fadeIn {
    from {
      transform: translateX(100px);
      opacity: 0;
    }
    to {
      transform: translateX(0);
      opacity: 1;
    } 
  }

  @keyframes fadeOut {
    from {
      transform: translateX(0);
      opacity: 1;
    }
    to {
      transform: translateX(100px);
      opacity: 1;
    } 
  }

  .dns-stdo-plgro {
    background-image: linear-gradient(to bottom, #ff5379, #ff466e, #ff3763, #ff2557, #ff004b);
    color: #66001B;
    font-weight: 600;
    padding: 0 10px;
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
  }
  .dns-stdo-pccon {
    background-image: linear-gradient(to bottom, #ff9d72, #ff8b59, #ff7941, #ff6527, #ff4d00);
    color: #832800;
    font-weight: 600;
    padding: 0 10px;
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
  }
  .dns-stdo-avtcia {
    background-image: linear-gradient(to bottom, #ffde7a, #ffd764, #ffd04d, #ffc832, #ffc000);
    color: #816100;
    font-weight: 600;
    padding: 0 10px;
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
  }
  .dns-stdo-etble {
    background-image: linear-gradient(to bottom, #7aaeff, #5f9dff, #448bff, #2778ff, #0064ff);
    color: #003383;
    font-weight: 600;
    padding: 0 10px;
    border-radius: 15px;
    box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;
  }

</style>