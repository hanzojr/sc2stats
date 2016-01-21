package com.alqteam.sc2stats.view;

import java.util.Iterator;
import java.util.List;
import javax.inject.Inject;
import br.gov.frameworkdemoiselle.annotation.NextView;
import br.gov.frameworkdemoiselle.annotation.PreviousView;
import br.gov.frameworkdemoiselle.stereotype.ViewController;
import br.gov.frameworkdemoiselle.template.AbstractListPageBean;
import br.gov.frameworkdemoiselle.transaction.Transactional;
import com.alqteam.sc2stats.business.PlayerBC;
import com.alqteam.sc2stats.domain.Player;

@ViewController
@NextView("./player_edit.jsf")
@PreviousView("./player_list.jsf")
public class PlayerListMB extends AbstractListPageBean<Player, Long> {

	private static final long serialVersionUID = 1L;

	@Inject
	private PlayerBC playerBC;
	
	@Override
	protected List<Player> handleResultList() {
		return this.playerBC.findAll();
	}
	
	@Transactional
	public String deleteSelection() {
		boolean delete;
		for (Iterator<Long> iter = getSelection().keySet().iterator(); iter.hasNext();) {
			Long id = iter.next();
			delete = getSelection().get(id);
			if (delete) {
				playerBC.delete(id);
				iter.remove();
			}
		}
		return getPreviousView();
	}

}