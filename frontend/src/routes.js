import React from "react";

export const routes = {
  '/': React.lazy(() => import('./pages/List')),
  '/add-product': React.lazy(() => import('./pages/AddNew')),
};
