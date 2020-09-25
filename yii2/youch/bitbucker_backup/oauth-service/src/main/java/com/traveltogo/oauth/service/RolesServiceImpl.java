package com.traveltogo.oauth.service;

import com.traveltogo.oauth.entity.Roles;
import com.traveltogo.oauth.repository.RolesRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

/**
 * Created by allinse on 05.09.16.
 */
@Service
public class RolesServiceImpl implements RolesService {

   @Autowired
   RolesRepository rolesRepository;

    @Override
    @Transactional
    public Roles getRole(String role) {
        return rolesRepository.findByRole(role);
    }
}
