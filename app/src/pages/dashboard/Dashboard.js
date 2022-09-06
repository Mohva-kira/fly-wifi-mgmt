import React from 'react'
import './dashboard.css'

const Dashboard = () => {
    return (
        <div>
            <div class="container">
                
                <h4>Choisissez vôtre forfait</h4>

                <div class="row" id="ads">

                    <div class="col-md-4">
                        <div class="card rounded">
                            <div class="card-image">
                                <span class="card-notify-badge">100 Fcfa</span>
                                <img class="img-fluid" src="https://imageonthefly.autodatadirect.com/images/?USER=eDealer&PW=edealer872&IMG=USC80HOC011A021001.jpg&width=440&height=262" alt="Alternate Text" />
                            </div>
                            <div class="card-image-overlay m-auto">
                                <span class="card-detail-badge">1 Heure</span>
                            </div>
                            <div class="card-body text-center">
                            
                                <a class="ad-btn" href="#">Payer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card rounded">
                            <div class="card-image">
                                <span class="card-notify-badge">200 Fcfa</span>

                                <img class="img-fluid" src="https://imageonthefly.autodatadirect.com/images/?USER=eDealer&PW=edealer872&IMG=CAC80HOC021B121001.jpg&width=440&height=262" alt="Alternate Text" />
                            </div>
                            <div class="card-image-overlay m-auto">

                                <span class="card-detail-badge">3 Heures</span>

                            </div>
                            <div class="card-body text-center">
                                {/* <div class="ad-title m-auto">
                                    <h5>Honda CIVIC HATCHBACK LS</h5>
                                </div> */}
                                <a class="ad-btn" href="#">Payer</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card rounded">
                            <div class="card-image">
                                <span class="card-notify-badge">500 Fcfa</span>

                                <img class="img-fluid" src="https://imageonthefly.autodatadirect.com/images/?USER=eDealer&PW=edealer872&IMG=USC80HOC091A021001.jpg&width=440&height=262" alt="Alternate Text" />
                            </div>
                            <div class="card-image-overlay m-auto">

                                <span class="card-detail-badge">9 Heures</span>

                            </div>
                            <div class="card-body text-center">
                                {/* <div class="ad-title m-auto">
                                    <h5>Honda Accord Hybrid LT</h5>
                                </div> */}
                                <a class="ad-btn" href="#">Payer</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    )
}

export default Dashboard