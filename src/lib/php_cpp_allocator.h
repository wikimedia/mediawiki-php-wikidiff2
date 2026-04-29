#ifndef PHP_CPP_ALLOCATOR_H
#define PHP_CPP_ALLOCATOR_H

#include <memory>
#include "php.h"

namespace wikidiff2 {

/**
 * Allocation class which allows various C++ standard library functions
 * to allocate and free memory using PHP's emalloc/efree facilities.
 */
template <class T>
struct PhpAllocator {
	using value_type = T;
	template <class U> struct rebind { using other = PhpAllocator<U>; };

	PhpAllocator() noexcept = default;
	template <class U> PhpAllocator(const PhpAllocator<U>&) noexcept {}

	T* allocate(std::size_t n) {
		return static_cast<T*>(safe_emalloc(n, sizeof(T), 0));
	}
	void deallocate(T* p, std::size_t) noexcept { efree(p); }

};

template<class T, class U>
bool operator==(const PhpAllocator <T>&, const PhpAllocator <U>&) { return true; }

template<class T, class U>
bool operator!=(const PhpAllocator <T>&, const PhpAllocator <U>&) { return false; }

} // namespace wikidiff2

#endif
