<style type="text/css">
body{
  overflow: hidden;
}

.dns_ctinerlgo{
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}
.dns_ctinerlgo .dns_lgo{
  position: absolute;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50%;
  height: 100%;
  background-image: linear-gradient(to top, #2195f9, #0b7ae2, #005fcb, #0445b2, #0c2a98);
  z-index: 2;
}

.dns_ctinerlgin{
  height: 100vh;
  display: flex;
  flex-direction: column; 
  align-items: center;
  justify-content: center;
  background-color: #fff;
  position: relative;
}

.dns_ctinerlgin .dns_ttlelogin{ 
  width:100%;
  height: 140px;
  display: flex; 
  justify-content: center;
  font-size: 3rem;
  font-weight: 600;
  color: #0A2B98;
}


.dns_ctinerlgin .dns_cardlgin{
  padding: 10px ;
} 

.dns_ctinerlgin .dns_cardlgin .dns_iputbox{
  padding: 5px 0;
  display: flex;
  align-items: center;
  position: relative;
} 
.dns_ctinerlgin .dns_cardlgin .dns_iputbox i{
  position: absolute;
  right: 10px;
  font-size: 3rem;
  color: #3A3BD1;
} 

.dns_ctinerlgin .dns_cardlgin .dns_iputbox input{
  font-size: 1.2rem;
  font-weight: 500;
  width: 100%;
  padding: 10px 20px;
  margin: 5px 0;
  outline: none;
  border: 0px;
  border-radius: 25px;
  box-shadow: rgba(58, 87, 232, 0.18) 0px 2px 4px;
} 

.dns_ctinerlgin .dns_btnlginbox{
  display: flex;
  justify-content: center;
} 

.dns_ctinerlgin .dns_btnlginbox button{
  font-size: 1.2rem;
  outline: none;
  background-color: #3A3BD1;
  color: #FFF;
  border: 0px solid transparent;
  padding: 10px 15px;
  border-radius: 12px;

} 

    .wave {
      height: 180px;
      width: 120%;
      overflow: hidden;
      position: absolute;
      bottom: -35px;
      animation: 5s wave ease-in-out infinite alternate;
    }
    .wave.a {
      background-position: 0 -854px;
    }
    .wave.b {
      background-position: 0 -427px;
      animation-delay: .6s;
    }
    .wave.c {
      background-position: 0 0;
      animation-delay: 1.2s;
    }
    /*.container {
      position: absolute;
    }*/
    @keyframes wave {
      0% {
        transform: translate(0 , 0);
      }
      50% {
        transform: translate(13px, -34px);
      }
      100% {
        transform: translate(-13px, -15px);
      }
    }
/*  */

@media(max-width: 767px){
  .dns_ctinerlgo{
    height: 30vh;
  }
.dns_ctinerlgo .dns_lgo{
  width: 100%;
  height: 30vh;
}
  .dns_ctinerlgin{
    height: 70vh;
  }
}
.dns_ctinerlgin #sq {
  -webkit-animation-name: animar;
  -webkit-animation-duration: 20s;
  -webkit-animation-timing-function: lineal;
  -webkit-animation-iteration-count:infinite;
  opacity: 0.6;
  margin:0;
  position:absolute;
  left: 0;
  top: -50px;
}
.circ1{   
  width:120px;
  height:120px;   
  border-radius:120px;
  background-color:rgb(255, 255, 255);   
  margin:20px 0 0 60px;
  box-shadow: rgba(58, 87, 232, 0.18) 0px 2px 4px;  
}


.circ2{
  width:150px;
  height:80px;      
  border-radius: 80px / 50px;
  background-color:rgb(255, 255, 255);   
  margin:-90px 0 0 80px;
  box-shadow: rgba(58, 87, 232, 0.18) 0px 2px 4px;
}
      
.circ3{
  width:150px;
  height:90px;   
  border-radius: 80px / 50px;
  background-color:rgb(255, 255, 255);   
  margin:-90px 0 0 0px;   
  box-shadow: rgba(58, 87, 232, 0.18) 0px 2px 4px;
}
</style>