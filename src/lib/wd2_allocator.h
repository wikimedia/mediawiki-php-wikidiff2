#ifndef WD2_ALLOCATOR_H
#define WD2_ALLOCATOR_H

#include <memory>

#if defined(HAVE_CONFIG_H)
	#define WD2_ALLOCATOR wikidiff2::PhpAllocator
	#include "php_cpp_allocator.h"
#else
	#define WD2_ALLOCATOR std::allocator
#endif

#endif
