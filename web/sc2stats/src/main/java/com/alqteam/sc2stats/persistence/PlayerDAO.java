package com.alqteam.sc2stats.persistence;

import br.gov.frameworkdemoiselle.stereotype.PersistenceController;
import br.gov.frameworkdemoiselle.template.JPACrud;

import com.alqteam.sc2stats.domain.Player;

@PersistenceController
public class PlayerDAO extends JPACrud<Player, Long> {

	private static final long serialVersionUID = 1L;
	

}
