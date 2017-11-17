				<h2 class="post-title vehicle-price">
					<?php

					if( isset( $GLOBALS['_dealer_settings']['price_display_type'] ) ) {
						switch ($GLOBALS['_dealer_settings']['price_display_type']) {
							// display new parice and old price, as on genegormans.com
							case 'genes':
								if ($vehicle->prices['msrp'] > 0 && $vehicle->prices['down_payment'] > 0) {
									echo sprintf('Now $%s',number_format($vehicle->prices['msrp'], 0, '.', ',' ));
									echo sprintf('<span class="price-was">WAS $%s</span>',number_format($vehicle->prices['down_payment'], 0, '.', ',' ));
								} else {
									echo $vehicle->price('Call For Price');
								}
								break;
							// down payment and/or full price
							case 'full_or_down':
								if ($vehicle->prices['down_payment'] > 0) {
									if ($vehicle->price > 0) {
										echo sprintf('$%s / $%s Down',number_format($vehicle->price, 0, '.', ',' ),number_format($vehicle->prices['down_payment'], 0, '.', ',' ));
									} else {
										echo sprintf('$%s Down',number_format($vehicle->prices['down_payment'], 0, '.', ',' ));
									}
								} else {
									echo $vehicle->price('Call For Price');
								}
								break;

							// this is the default price display
							default:
								echo $vehicle->price('Call For Price');
								break;
						}
					} else {
						echo $vehicle->price('Call For Price');
					}

					?>
				</h2>