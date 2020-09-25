package com.traveltogo.oauth.repository;

import com.traveltogo.oauth.entity.Roles;
import org.springframework.data.repository.CrudRepository;

/**
 * Created by allinse on 05.09.16.
 */

public interface RolesRepository extends CrudRepository<Roles, Long> {
    Roles findByRole(String role);
}