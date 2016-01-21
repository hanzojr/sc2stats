
package com.alqteam.sc2stats.business;

import br.gov.frameworkdemoiselle.stereotype.BusinessController;
import br.gov.frameworkdemoiselle.template.DelegateCrud;
import com.alqteam.sc2stats.domain.*;
import java.util.*;
import javax.faces.model.*;
import com.alqteam.sc2stats.persistence.PlayerDAO;

// To remove unused imports press: Ctrl+Shift+o

@BusinessController
public class PlayerBC extends DelegateCrud<Player, Long, PlayerDAO> {
	private static final long serialVersionUID = 1L;
	
	
}
